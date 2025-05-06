<?php

namespace App\Models;

use App\Traits\HasComments;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{

    use HasComments;
    protected $fillable = ['title', 'slug', 'content'];
    public function meta() 
    {
        return $this->morphOne(Meta::class,"metaable");
    }

    public function tags() 
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function latest_comment() 
    {
        return $this->morphOne(Comment::class, 'commentable')->latestOfMany();
    }
}
