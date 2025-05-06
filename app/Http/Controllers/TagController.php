<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Inertia\Inertia;

class TagController extends Controller
{
    public function show(Tag $tag)
    {
        $posts = $tag->posts;
        return Inertia::render('Tag/Show', compact('posts', 'tag'));
    }
}
