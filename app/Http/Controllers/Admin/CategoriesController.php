<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        if ($request->q) {
            $categories = Category::where('name', 'like', '%'.$request->q.'%')->orderBy('name')->paginate(20, ['id', 'name']);
        } else {
            $categories = Category::orderBy('name')->paginate(20, ['id', 'name']);
        }

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function edit($id)
    {
        $category = Category::whereId($id)->firstOrFail();

        return view('admin.categories.edit', compact('category'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'categoryName' => 'required|string|max:255|unique:categories,name',
            'icon' => 'required|string|max:255',
        ]);

        Category::create([
            'name' => $request->categoryName,
            'order' => $request->order,
            'icon' => $request->icon,
        ]);

        Cache::forget('categories');

        return redirect()->back()->with('success_message', 'New Category added Successfully');
    }

    public function update(Request $request)
    {
        $request->validate([
            'categoryName' => 'required|string|max:255|unique:categories,name,'.$request->get('id').'id',
            'icon' => 'required|string|max:255',
        ]);

        $category = Category::whereId($request->id)->firstOrFail();

        $category->name = $request->categoryName;
        $category->icon = $request->icon;
        $category->order = $request->order;
        $category->save();

        Cache::forget('categories');

        return redirect()->back()->with('success_message', 'Category updated Successfully');
    }

    public function destroy($id)
    {
        Category::whereId($id)->firstOrFail()->delete();

        Cache::forget('categories');

        return redirect()->back()->with('success_message', 'Deleted Successfully');
    }
}
