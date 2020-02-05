<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    public function index()
    {
        $pages = Page::all(['name', 'id']);

        return view('admin.cms.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.cms.create');
    }

    public function edit($id)
    {
        $page = Page::whereId($id)->firstOrFail();

        return view('admin.cms.edit', compact('page'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:pages,name'
        ]);

        Page::create(['name' => $request->name]);

        return redirect('admin/pages')->with('success_message', 'Page created successfully!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:pages,name,'.$request->page_id,
        ]);

        $page = Page::whereId($request->page_id)->firstOrFail();

        $page->fill(['name' => $request->name])->save();

        return redirect()->back()->with('success_message', 'Page updated successfully!');
    }

    public function destroy($id)
    {
        Page::whereId($id)->delete();

        return redirect()->back()->with('success_message', 'Page deleted successfully!');
    }
}
