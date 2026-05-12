<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ImagenProducto extends Model
{
    use HasFactory;

    protected $table = 'IMAGENES_PRODUCTO';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'url', 'principal', 'id_producto'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }

    public function getUrlCompletaAttribute()
    {
        if (preg_match('/^https?:\/\//', $this->url)) {
            return $this->url;
        }

        if (env('AWS_IMAGES_PRIVATE', true)) {
            return Storage::disk('s3')->temporaryUrl($this->url, now()->addHours(6));
        }

        return Storage::disk('s3')->url($this->url);
    }
}
