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
