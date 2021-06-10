<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImageTemplate extends Model
{
    use SoftDeletes;

    protected $fillable = ['image_id', 'template'];
    protected $casts = ['template' => 'array'];

    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
