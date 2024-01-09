<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Logo extends Model
{
    protected $guarded = ['id'];

    public function setFilepathAttribute($file)
    {
        $path = $file->store('images', 'logos');
        $this->attributes['filepath'] = $path;
    }

    public function getFilepathAttribute($file_name)
    {
        return Storage::disk('logos')->url($file_name);
    }
}
