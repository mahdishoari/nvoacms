<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    // public function posts()
    // {
    //     return $this->belongsToMany(Post::class);
    // }

    protected $fillable = ['name'];
    public function taggable()
    {
        return $this->morphTo();
    }

    public function posts()
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }

    public function pages()
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }
}
