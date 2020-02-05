<?php
namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\ExpertiseVendor;
use App\Models\LocationVendor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Vendor;

class ManagementController extends Controller
{
    public function index()
    {
        return view('admin.management.index');
    }
}
