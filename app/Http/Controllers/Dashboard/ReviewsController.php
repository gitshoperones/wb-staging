<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class ReviewsController extends Controller
{
    public function index()
    {
        return view('dashboard.vendor.reviews');
    }
}
