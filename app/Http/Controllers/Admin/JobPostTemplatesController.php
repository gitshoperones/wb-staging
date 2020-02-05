<?php

namespace App\Http\Controllers\Admin;

use App\Models\JobPostTemplate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function GuzzleHttp\json_encode;

class JobPostTemplatesController extends Controller
{
    public function index()
    {
        $templates = JobPostTemplate::paginate(10, ['id', 'title']);

        return view('admin.job-post-templates.index', compact('templates'));
    }

    public function create()
    {
        $fieldTypes = [
            'text' => 'Short Text',
            'ltext' => 'Long Text',
            'numeric' => 'Numeric',
            'currency' => 'Currency',
            'date' => 'Date',
            'time2' => 'Time',
            'custom' => 'Custom Option List (Single Choice)',
            'custom_multi' => 'Custom Option List (Multi Choice)',
            'address' => 'Address (Only 1 per template)',
            'property' => 'Property Type List (Only 1 per template)',
            'other' => 'Other Requirements List (Only 1 per template)', //Property Features
            'website' => 'Website Requirements List (Only 1 per template)',
            'time' => 'Time Requirements List (Only 1 per template)',
        ];
        return view('admin.job-post-templates.create', compact('fieldTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:job_post_templates,title|max:255',
            // 'body' => 'required',
        ]);

        $data = $request->only(['title', 'body', 'custom_text']);
        $data['approximate'] = ($request->approximate) ? 1 : 0;
        $data['approxDisplay'] = ($request->approxDisplay) ? 1 : 0;
        $data['fields'] = ($request->fields) ? json_encode($request->fields) : null;
        $data['images_option'] = ($request->images_option) ? 1 : 0;

        JobPostTemplate::create($data);

        return redirect('/admin/job-post-templates')->with('success_message', 'New Job Post Template created successfully!');
    }

    public function edit($id)
    {
        $template = JobPostTemplate::whereId($id)->firstOrFail();
        $fieldTypes = [
            'text' => 'Short Text',
            'ltext' => 'Long Text',
            'numeric' => 'Numeric',
            'currency' => 'Currency',
            'date' => 'Date',
            'time2' => 'Time',
            'custom' => 'Custom Option List (Single Choice)',
            'custom_multi' => 'Custom Option List (Multi Choice)',
            'address' => 'Address (Only 1 per template)',
            'property' => 'Property Type List (Only 1 per template)',
            'other' => 'Other Requirements List (Only 1 per template)', //Property Features
            'website' => 'Website Requirements List (Only 1 per template)',
            'time' => 'Time Requirements List (Only 1 per template)',
        ];
        return view('admin.job-post-templates.edit', compact('template', 'fieldTypes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255|unique:job_post_templates,title,'. $request->template_id,
            // 'body' => 'required',
        ]);

        $data = $request->only(['title', 'body', 'custom_text']);
        $data['approximate'] = ($request->approximate) ? 1 : 0;
        $data['approxDisplay'] = ($request->approxDisplay) ? 1 : 0;
        $data['fields'] = ($request->fields) ? json_encode($request->fields) : null;
        $data['images_option'] = ($request->images_option) ? 1 : 0;

        $template = JobPostTemplate::whereId($id)->firstOrFail();
        $template->update($data);

        return redirect()->back()->with('success_message', 'Template updated successfully!');
    }

    public function destroy($id)
    {
        JobPostTemplate::whereId($id)->delete();

        return redirect()->back()->with('success_message', 'Template deleted successfully!');
    }
}
