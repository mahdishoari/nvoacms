<?php

namespace App\Models;

use App\Traits\HasComments;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasComments, HasFactory;
    protected $fillable = ['title', 'description', 'content'];

    public function author()
    {
        return $this->belongsTo(User::class);
    }    

    public function postComment()
    {
        return $this->morphMany(Comment::class,'commentable')->where('commentable_type', Post::class);
    }

    public function latest_comment() 
    {
        return $this->morphOne(Comment::class, 'commentable')->latestOfMany();
    }

    // public function tags() 
    // {
    //     return $this->belongsToMany(Tag::class);
    // }

    public function tags() 
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function meta() 
    {
        return $this->morphOne(Meta::class,"metaable");
    }
}
