<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use App\Models\PageSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PageSettingsController extends Controller
{
    public function index($pageId)
    {
        $page = Page::whereId($pageId)->with('pageSettings')->firstOrFail();

        return view('admin.cms.page-settings-index', compact('page'));
    }

    public function create($pageId)
    {
        $page = Page::whereId($pageId)->firstOrFail();

        return view('admin.cms.page-settings-create', compact('page'));
    }

    public function store(Request $request)
    {
        $settingType = 'meta_value_text';
        $valids = 'required';

        if(!$request->meta_type) {
            $settingType = 'meta_type';
        } else {
            if($request->meta_type=='text') {
                $settingType = 'meta_value_text';
            } elseif($request->meta_type=='image') {
                $settingType = 'meta_value_image';
                $valids = 'required|mimes:jpg,jpeg,png|max:10000';
            } else {
                $settingType = 'meta_value_file';
                $valids = 'required|mimes:pdf,doc,docx|max:10000';
            }
        }

        $request->validate([
            'meta_key' => 'required|max:255',
            $settingType => $valids,
        ]);

        $data = [
            'meta_key' => $request->meta_key,
            'meta_type' => $request->meta_type,
            'page_id' => $request->pageId,
        ];

        if ($request->meta_value_image && $request->meta_type === 'image') {
            $data['meta_value'] = $request->meta_value_image->store('user-uploads');
        } elseif ($request->meta_value_file && $request->meta_type === 'file') {
            $data['meta_value'] = $request->meta_value_file->store('user-uploads');
        } else {
            $data['meta_value'] = $request->meta_value_text;
        }

        PageSetting::create($data);
        
        return redirect()->back()->with('success_message', 'Page setting saved successfully!');
    }

    public function edit($pageId, PageSetting $pageSetting)
    {
        return view('admin.cms.page-settings-edit', compact('pageId', 'pageSetting'));
    }

    public function update(Request $request, PageSetting $pageSetting)
    {
        $request->validate([
            'meta_key' => 'required|max:255',
            'meta_value_image' => 'sometimes|nullable|mimes:jpg,jpeg,png|max:10000',
            'meta_value_file' => 'sometimes|nullable|mimes:pdf,doc,docx|max:10000',
        ]);

        $data = [
            'meta_key' => $request->meta_key,
            'meta_type' => $request->meta_type
        ];
        
        if ($request->meta_value_image && $request->meta_type === 'image') {
            Storage::delete($pageSetting->meta_value);

            $data['meta_value'] = $request->meta_value_image->store('user-uploads');
        } elseif ($request->meta_value_file && $request->meta_type === 'file') {
            Storage::delete($pageSetting->meta_value);

            $data['meta_value'] = $request->meta_value_file->store('user-uploads');
        } else {
            $data['meta_value'] = $request->meta_value_text;
        }

        $pageSetting->update($data);

        return redirect()
            ->action('Admin\PageSettingsController@index', ['id' => $request->pageId])
            ->with('success_message', 'Page setting updated successfully!');
    }

    public function destroy(PageSetting $pageSetting)
    {
        if ($pageSetting->meta_type == 2)
            Storage::delete($pageSetting->meta_value);

        $pageSetting->delete();

        return back()->with('success_message', 'Page setting deleted successfully!');
    }

    public function updateOrder(Request $request, Page $page)
    {
        $pageSettingIds = collect($request->pageSettings)->map(function ($value) {
            return (int) str_replace('page_setting_id_', '', $value);
        });
        
        foreach ($pageSettingIds as $key => $id) {
            $page->pageSettings()->find($id)->update(['order' => $key]);
        }

        return response()->json([
            'success' => 'Update Success'
        ]);
    }
}
