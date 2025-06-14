<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class comment extends Model
{
    use HasFactory, softDeletes;
    protected $fillable = ['body', 'status', 'email'];

    public function commentable()
    {
        return $this->morphTo();
    }
}
