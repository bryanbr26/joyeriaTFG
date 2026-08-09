<?php

namespace App\Http\Controllers;

use App\Services\ImageService;
use Illuminate\Support\Str;

/**
 * ImageController - Sirve imágenes optimizadas, placeholders y WebP con cache agresivo.
 *
 * Actúa como proxy de imágenes para generar versiones redimensionadas,
 * convertir formatos y enviar headers de cache de larga duración.
 */
class ImageController extends Controller
{
    /** @var \App\Services\ImageService Servicio de procesamiento de imágenes */
    protected $imageService;

    /**
     * Constructor del controlador de imágenes.
     *
     * @param \App\Services\ImageService $imageService
     */
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Sirve una imagen optimizada, placeholder o WebP con headers de cache agresivos.
     *
     * @param string $size thumbnail|small|medium|large|placeholder|webp
     * @param string $path Ruta relativa de la imagen original
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\Response
     */
    public function show(string $size, string $path)
    {
        // Sanitizar path: evitar directory traversal
        $path = ltrim($path, '/');
        if (Str::contains($path, '..')) {
            abort(404);
        }

        $cachedPath = null;

        if ($size === 'placeholder') {
            $cachedPath = $this->imageService->generarPlaceholder($path);
        } elseif ($size === 'webp') {
            $cachedPath = $this->imageService->convertirWebp($path);
        } else {
            $cachedPath = $this->imageService->optimizar($path, $size);
        }

        return $this->serveCached($cachedPath);
    }

    /**
     * Sirve una imagen remota (S3 u otro origen) optimizada.
     *
     * @param string $size thumbnail|small|medium|large|placeholder|webp
     * @param \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\Response
     */
    public function remote(string $size, \Illuminate\Http\Request $request)
    {
        $url = $request->input('url');

        if (!$url || !filter_var($url, FILTER_VALIDATE_URL)) {
            abort(404);
        }

        $cachedPath = null;

        if ($size === 'placeholder') {
            $cachedPath = $this->imageService->generarPlaceholderUrl($url);
        } elseif ($size === 'webp') {
            $cachedPath = $this->imageService->convertirWebp($url);
        } else {
            $cachedPath = $this->imageService->optimizarUrl($url, $size);
        }

        return $this->serveCached($cachedPath);
    }

    /**
     * Sirve un archivo cacheado con headers agresivos.
     *
     * @param string|null $cachedPath
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\Response
     */
    protected function serveCached(?string $cachedPath)
    {
        if (!$cachedPath) {
            abort(404);
        }

        $fullPath = storage_path('app/public/' . $cachedPath);

        if (!file_exists($fullPath)) {
            abort(404);
        }

        $mimeType = mime_content_type($fullPath) ?: 'image/jpeg';

        return response()->file($fullPath, [
            'Content-Type' => $mimeType,
            'Cache-Control' => 'public, max-age=31536000, immutable',
            'Expires' => now()->addYear()->toRfc7231String(),
        ]);
    }
}
