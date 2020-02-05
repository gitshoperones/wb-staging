<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class DatabaseBackupController extends Controller
{
    public function create()
    {
        return view('admin.database-backup');
    }

    public function store(Request $request)
    {
        Artisan::queue('backup:run', [
            '--only-db' => 1
        ]);

        $notifiable = config('backup.notifications.mail.to');

        return redirect()->back()->with(
            'success_message',
            "Database backup request was added to the queue. This will be saved to {$notifiable} drive once done"
        );
    }
}
