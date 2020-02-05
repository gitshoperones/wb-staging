<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\JobPostTemplate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssignTemplateCategoryController extends Controller
{
    public function create()
    {
        $templates = JobPostTemplate::orderBy('title')->get(['id', 'title']);
        $templateCategories = [];

        if (request('template_id')) {
            $templateCategories = JobPostTemplate::whereId(request('template_id'))
                ->firstOrFail()->categories()->pluck('categories.id')->toArray();
        }

        $categories = Category::doesnthave('jobPostTemplates')
            ->orWhereIn('id', $templateCategories)
            ->orderBy('name')->get(['id', 'name']);

        return view(
            'admin.job-post-templates.assign-template-category',
            compact('categories', 'templates', 'templateCategories')
        );
    }

    public function update(Request $request)
    {
        $request->validate([
            'template_id' => 'required|exists:job_post_templates,id|max:255',
        ]);

        JobPostTemplate::whereId($request->template_id)->firstOrFail()
            ->categories()->sync($request->categories ?: []);


        return redirect()->back()->with('success_message', 'Template categories updated.');
    }
}
