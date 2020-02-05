<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;

class EmailTemplatesController extends Controller
{
    public $email_template;

    function __construct()
    {
        $this->email_template = new EmailTemplate();
    }

    public function index()
    {
        $email_templates = $this->email_template->getAll();
        return view('admin.email-templates.index', compact('email_templates'));
    }

    public function edit($id)
    {
        $email_template = $this->email_template->getById($id);
        return view('admin.email-templates.edit', compact('email_template'));
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'content' => 'required',
        ]);
        
        $data = $request->only([
            'name', 'content'
        ]);
        
        if ($this->email_template->setUpdate($id, $data)) {
            return back()->with('success_message', "Successfully updated");
        } else {
            return back()->with('error', "Failed to update");
        }
    }
}
