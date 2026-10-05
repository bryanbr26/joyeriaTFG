<?php

if (!function_exists('webp_picture')) {
    /**
     * Genera un tag <picture> con fuente WebP y fallback al formato original.
     *
     * @param string $path Ruta relativa dentro de public/images (ej: 'joyas/banner-1.png')
     * @param string $alt Texto alternativo
     * @param array $attrs Atributos adicionales para la etiqueta <img>
     * @param string|null $webpWidth Ancho máximo de la versión WebP generada (opcional, para srcset futuro)
     * @return string HTML del picture
     */
    function webp_picture(string $path, string $alt = '', array $attrs = []): string
    {
        $originalUrl = asset('images/' . ltrim($path, '/'));
        $webpPath = preg_replace('/\.[^.]+$/', '.webp', $path);
        $webpUrl = asset('images/' . ltrim($webpPath, '/'));
        $webpFullPath = public_path('images/' . ltrim($webpPath, '/'));

        $attrString = '';
        foreach ($attrs as $key => $value) {
            if (is_bool($value)) {
                if ($value) {
                    $attrString .= ' ' . $key;
                }
            } else {
                $attrString .= ' ' . $key . '="' . e($value) . '"';
            }
        }

        $hasWebp = file_exists($webpFullPath);

        $html = '<picture>';
        if ($hasWebp) {
            $html .= '<source srcset="' . e($webpUrl) . '" type="image/webp">';
        }
        $html .= '<img src="' . e($originalUrl) . '" alt="' . e($alt) . '"' . $attrString . '>';
        $html .= '</picture>';

        return $html;
    }
}

if (!function_exists('optimized_image_url')) {
    /**
     * Genera la URL de una imagen optimizada remota (S3).
     *
     * @param string|null $url URL original de la imagen
     * @param string $size Tamaño deseado
     * @return string|null URL optimizada o null
     */
    function optimized_image_url(?string $url, string $size = 'medium'): ?string
    {
        if (!$url) {
            return null;
        }

        // Las imágenes del disco local 'public' se sirven tal cual:
        // el optimizador remoto no puede descargar la propia app desde el contenedor
        $ruta = parse_url($url, PHP_URL_PATH) ?: '';
        if (strpos($ruta, '/storage/') === 0) {
            return $url;
        }

        // El optimizador remoto solo acepta URLs absolutas
        if (!preg_match('/^https?:\/\//', $url)) {
            return $url;
        }

        return route('imagen.optimizada.remota', [
            'size' => $size,
            'url' => $url,
        ]);
    }
}

if (!function_exists('responsive_picture')) {
    /**
     * Genera un tag <picture> con WebP, placeholder LQIP y lazy loading real.
     *
     * @param string $path Ruta relativa dentro de public/images
     * @param string $alt Texto alternativo
     * @param array $attrs Atributos adicionales
     * @return string HTML del picture
     */
    function responsive_picture(string $path, string $alt = '', array $attrs = []): string
    {
        $originalUrl = asset('images/' . ltrim($path, '/'));
        $webpPath = preg_replace('/\.[^.]+$/', '.webp', $path);
        $webpUrl = asset('images/' . ltrim($webpPath, '/'));
        $webpFullPath = public_path('images/' . ltrim($webpPath, '/'));

        $defaults = [
            'loading' => 'lazy',
            'decoding' => 'async',
            'class' => 'lazy-image blur-up',
        ];

        $attrs = array_merge($defaults, $attrs);

        // Si hay data-src no se toca; si no, se configura el placeholder
        if (!isset($attrs['data-src'])) {
            $attrs['data-src'] = file_exists($webpFullPath) ? $webpUrl : $originalUrl;
            $attrs['src'] = 'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 1 1%22%3E%3C/svg%3E';
        }

        $attrString = '';
        foreach ($attrs as $key => $value) {
            if (is_bool($value)) {
                if ($value) {
                    $attrString .= ' ' . $key;
                }
            } else {
                $attrString .= ' ' . $key . '="' . e($value) . '"';
            }
        }

        $hasWebp = file_exists($webpFullPath);

        $html = '<picture>';
        if ($hasWebp) {
            $html .= '<source data-srcset="' . e($webpUrl) . '" type="image/webp">';
        }
        $html .= '<img' . $attrString . ' alt="' . e($alt) . '">';
        $html .= '</picture>';

        return $html;
    }
}

if (!function_exists('disco_imagenes_producto')) {
    /**
     * Devuelve el disco donde se almacenan las imágenes de producto.
     *
     * Usa S3 cuando está configurado (producción); en caso contrario
     * recurre al disco 'public' (desarrollo local).
     *
     * @return string Nombre del disco: 's3' o 'public'
     */
    function disco_imagenes_producto(): string
    {
        $s3Configurado = !empty(config('filesystems.disks.s3.bucket'))
            && !empty(config('filesystems.disks.s3.key'));

        return $s3Configurado ? 's3' : 'public';
    }
}
