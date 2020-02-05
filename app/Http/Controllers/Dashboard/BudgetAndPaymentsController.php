<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class BudgetAndPaymentsController extends Controller
{
    public function index()
    {
        return view('dashboard.couple.budget-and-payments');
    }
}
