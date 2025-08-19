<?php

namespace App\Models;

use App\Http\Resources\DatagridTagResource;
use http\Env\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Inertia\Inertia;

class Tag extends Model
{
    use HasFactory;
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
