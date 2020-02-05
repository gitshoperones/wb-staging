<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContactUsRecord;

class ContactUsController extends Controller
{

    public function index($filter = null)
    {
        $contactRecords = ContactUsRecord::with('subscription')
                                ->orderBy('id', 'desc')
                                ->paginate(10);
                                
        if ($filter != null) {
            $contactRecords = ContactUsRecord::with('subscription')
                                ->where('status', ($filter == 'open') ? 1 : 2)
                                ->orderBy('id', 'desc')
                                ->paginate(10);
        }
        
        return view('admin.contact-us.index', compact('contactRecords', 'filter'));
    }

    public function update(Request $request, ContactUsRecord $contact_us)
    {
        $contact_us->update(['status' => $request->get('status')]);

        return back()->with('success_message', "Contact {$contact_us->email} marked successfully!");
    }

    public function destroy(ContactUsRecord $contact_us)
    {
        $contact_us->delete();

        return back()->with('success_message', "Successfully deleted message");
    }
}
