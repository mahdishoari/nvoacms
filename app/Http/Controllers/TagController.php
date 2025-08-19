<?php

namespace App\Http\Controllers;

use App\Events\TagCreated;
use App\Http\Resources\DatagridTagResource;
use App\Models\Tag;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TagController extends Controller
{
    public function show(Tag $tag)
    {
        $posts = $tag->posts;
        return Inertia::render('Tag/Show', compact('posts', 'tag'));
    }

    public function datagrid(Request $request)
    {
        $tags = Tag::with('taggable');
        if ($request->filter) {
            $tags = $tags->whereLike('name', "%{$request->filter}%");
        }
        $tags = $tags->paginate(10);
        $data = DatagridTagResource::collection($tags);
        return Inertia::render('Tags/Datagrid', compact('data'));
    }

    public function update(Request $request, Tag $tag)
    {
        $tag->name = $request->name;
        try {
            $tag->save();
        } catch (\Exception $e) {
            return redirect("/tags/datagrid")->withErrors([
                'error' => 'خط در ثبت تگ',
            ]);
        }

        return redirect('/tags/datagrid');
    }

    public function store(Request $request) {
        $tag = Tag::firstOrCreate([
            'name' => $request->input('name'),
        ],[
            'updated_at' => now(),
            'created_at' => now(),
        ]);

//         if a new tag has been created notify
        if ($tag->wasRecentlyCreated) {
            event(new TagCreated($tag));
        }

        return response()->json([
            'tag' => $tag
        ]);
    }

    public function edit(Tag $tag)
    {
        return Inertia::render('Tags/Edit', compact('tag'));
    }
}
