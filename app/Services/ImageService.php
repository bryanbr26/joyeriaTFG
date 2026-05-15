<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

/**
 * ImageService - Servicio de procesamiento y optimización de imágenes.
 *
 * Genera versiones redimensionadas, placeholders borrosos (LQIP) y
 * conversiones a WebP/JPEG con cacheo en disco para mejorar el rendimiento
 * de carga de imágenes del catálogo.
 */
class ImageService
{
    /** @var array<string, int> Mapa de tamaños de salida en píxeles de ancho */
    const SIZES = [
        'thumbnail' => 150,
        'small'     => 300,
        'medium'    => 600,
        'large'     => 1200,
    ];

    /** @var string Directorio relativo de cache dentro de storage/app/public */
    const CACHE_DIR = 'cache';

    /**
     * Determina si WebP está soportado por la instalación GD/Imagick.
     *
     * @return bool
     */
    protected function webpSupported(): bool
    {
        return function_exists('imagewebp') && (imagetypes() & IMG_WEBP);
    }

    /**
     * Obtiene el formato de salida preferido y su extensión.
     *
     * @return array [string $extension, string $mimeType]
     */
    protected function outputFormat(): array
    {
        if ($this->webpSupported()) {
            return ['webp', 'image/webp'];
        }
        return ['jpg', 'image/jpeg'];
    }

    /**
     * Resuelve la ruta física absoluta de una imagen dada su ruta relativa pública.
     * Busca primero en storage/app/public/ y luego en public/
     *
     * @param string $path Ruta relativa de la imagen
     * @return string|null Ruta absoluta o null si no existe
     */
    protected function resolvePath(string $path): ?string
    {
        $path = ltrim($path, '/');

        // Primero intentar en storage/app/public/
        $storagePath = storage_path('app/public/' . $path);
        if (file_exists($storagePath)) {
            return $storagePath;
        }

        // Luego en public/
        $publicPath = public_path($path);
        if (file_exists($publicPath)) {
            return $publicPath;
        }

        return null;
    }

    /**
     * Genera la ruta relativa de cache para una imagen procesada.
     *
     * @param string $path Ruta original
     * @param string $suffix Sufijo identificativo del procesamiento
     * @param string $extension Extensión de salida
     * @return string Ruta relativa del archivo cacheado
     */
    protected function cachePath(string $path, string $suffix, string $extension): string
    {
        $dir = dirname($path);
        $filename = pathinfo($path, PATHINFO_FILENAME);

        $cachedName = Str::slug($filename) . '-' . $suffix . '.' . $extension;
        $relativeDir = $dir !== '.' ? $dir : '';

        return self::CACHE_DIR . ($relativeDir ? '/' . $relativeDir : '') . '/' . $cachedName;
    }

    /**
     * Obtiene la ruta física completa del archivo cacheado.
     *
     * @param string $cachePath Ruta relativa del cache
     * @return string Ruta absoluta
     */
    protected function cachedFilePath(string $cachePath): string
    {
        return storage_path('app/public/' . $cachePath);
    }

    /**
     * Procesa una imagen: redimensiona manteniendo proporción, convierte al formato
     * optimizado y cachea. Si WebP no está disponible usa JPEG.
     *
     * @param string $path Ruta relativa de la imagen (ej: productos/foto.jpg o images/joyas/banner.png)
     * @param string $size Clave del tamaño (thumbnail, small, medium, large)
     * @return string|null Ruta relativa del archivo cacheado o null si no existe la fuente
     */
    public function optimizar(string $path, string $size = 'medium'): ?string
    {
        if (!isset(self::SIZES[$size])) {
            $size = 'medium';
        }

        $width = self::SIZES[$size];
        $sourcePath = $this->resolvePath($path);

        if (!$sourcePath) {
            return null;
        }

        [$format, $mime] = $this->outputFormat();
        $cacheRelative = $this->cachePath($path, $size, $format);
        $cacheFullPath = $this->cachedFilePath($cacheRelative);

        if (file_exists($cacheFullPath)) {
            return $cacheRelative;
        }

        try {
            $img = Image::make($sourcePath);
        } catch (\Exception $e) {
            // Si no se puede leer (p.ej. WebP sin soporte), devolver null
            return null;
        }

        $img->resize($width, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $cacheDir = dirname($cacheFullPath);
        if (!is_dir($cacheDir)) {
            mkdir($cacheDir, 0755, true);
        }

        if ($format === 'webp') {
            $img->encode('webp', 85);
        } else {
            // Para JPEG usamos fondo blanco en caso de transparencias
            $img->encode('jpg', 85);
        }

        $img->save($cacheFullPath);

        return $cacheRelative;
    }

    /**
     * Genera un placeholder borroso 20x20 para lazy loading (LQIP).
     *
     * @param string $path Ruta relativa de la imagen original
     * @return string|null Ruta relativa del placeholder cacheado
     */
    public function generarPlaceholder(string $path): ?string
    {
        $sourcePath = $this->resolvePath($path);

        if (!$sourcePath) {
            return null;
        }

        [$format, $mime] = $this->outputFormat();
        $cacheRelative = $this->cachePath($path, 'placeholder', $format);
        $cacheFullPath = $this->cachedFilePath($cacheRelative);

        if (file_exists($cacheFullPath)) {
            return $cacheRelative;
        }

        try {
            $img = Image::make($sourcePath);
        } catch (\Exception $e) {
            return null;
        }

        $img->resize(20, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $img->blur(8);

        $cacheDir = dirname($cacheFullPath);
        if (!is_dir($cacheDir)) {
            mkdir($cacheDir, 0755, true);
        }

        if ($format === 'webp') {
            $img->encode('webp', 60);
        } else {
            $img->encode('jpg', 60);
        }

        $img->save($cacheFullPath);

        return $cacheRelative;
    }

    /**
     * Convierte una imagen a formato WebP (o JPEG si WebP no está disponible).
     *
     * @param string $path Ruta relativa de la imagen original
     * @return string|null Ruta relativa del archivo cacheado
     */
    public function convertirWebp(string $path): ?string
    {
        $sourcePath = $this->resolvePath($path);

        if (!$sourcePath) {
            return null;
        }

        [$format, $mime] = $this->outputFormat();
        $cacheRelative = $this->cachePath($path, 'webp', $format);
        $cacheFullPath = $this->cachedFilePath($cacheRelative);

        if (file_exists($cacheFullPath)) {
            return $cacheRelative;
        }

        try {
            $img = Image::make($sourcePath);
        } catch (\Exception $e) {
            return null;
        }

        $cacheDir = dirname($cacheFullPath);
        if (!is_dir($cacheDir)) {
            mkdir($cacheDir, 0755, true);
        }

        if ($format === 'webp') {
            $img->encode('webp', 85);
        } else {
            $img->encode('jpg', 85);
        }

        $img->save($cacheFullPath);

        return $cacheRelative;
    }
}
