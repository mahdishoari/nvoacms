<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Notifications\CategoryCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::with('children')->whereNull('parent_id')->get();

        return Inertia::render('Categories/Index', compact('categories'));
    }
    public function store(Request $request) {
        $category = new Category();
        $category->name = $request->input('name');
        $category->slug = Str::slug($request->input('name')) ?: Str::random(8);
        $category->parent_id = $request->input('parent_id') ?? null;
        $category->user_id = Auth::id();

        try {
            $category->save();
            $category->notify(new CategoryCreated());
        } catch (\Exception $e) {
            return redirect('/categories')->withErrors(['خطا در اضافه کردن']);
        }
        return redirect('/categories')->with('success', 'با موفقیت اضافه شد');

    }
}
