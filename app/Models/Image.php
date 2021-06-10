<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'description', 'fromImage', 'fromSrc', 'repo', 'tag', 'message'];

    public function imageTemplate()
    {
        return $this->hasOne(ImageTemplate::class);
    }
}
