<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    protected $fillable = ['title', 'description', 'keyword'];

    public function metaable()
    {
        return $this->morphTo();
    }
}
