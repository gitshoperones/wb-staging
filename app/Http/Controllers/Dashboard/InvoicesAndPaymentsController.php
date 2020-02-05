<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Couple;
use App\Models\Invoice;
use App\Models\JobPost;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InvoicesAndPaymentsController extends Controller
{
    public function index()
    {
        $totalIncomingPayments = $totalCurrentYearRevenue = $totalOwing = $totalPaid = null;
        $account = Auth::user()->account;

        if ($account === 'vendor') {
            $invoiceQuery = Auth::user()->vendorProfile->invoices();
            $totalIncomingPayments = $invoiceQuery->sum('balance');
            $invoiceIds = $invoiceQuery->pluck('id');
            $totalCurrentYearRevenue = Payment::whereIn('invoice_id', $invoiceIds)
                ->whereYear('created_at', Carbon::today()->format('Y'))->sum('amount');
            $data = $this->vendor();
        } else {
            $invoiceQuery = Auth::user()->coupleProfile()->invoices();
            $totalOwing = $invoiceQuery->sum('balance');
            $invoiceIds = $invoiceQuery->pluck('id');
            $totalPaid = Payment::whereIn('invoice_id', $invoiceIds)->sum('amount');
            $data = $this->couple();
        }

        $view = sprintf('dashboard.%s.invoices-and-payments', Auth::user()->account);

        return view($view, compact(
            'data',
            'totalPaid',
            'totalOwing',
            'totalIncomingPayments',
            'totalCurrentYearRevenue'
        ));
    }

    public function vendor()
    {
        $vendor = Auth::user()->vendorProfile;

        $query = Invoice::where('vendor_id', $vendor->id);

        return $this->query($query);
    }

    public function couple()
    {
        $couple = Couple::where('userA_id', Auth::id())
                ->orWhere('userB_id', Auth::id())->firstOrFail();
        $query = Invoice::where('couple_id', $couple->id);

        return $this->query($query);
    }

    private function query($query)
    {
        return $query->with([
            'vendor'  => function ($q) {
                $q->addSelect(['id', 'user_id', 'business_name']);
            },
            'jobQuote' => function ($q) {
                $q->addSelect(['id', 'job_post_id'])->with([
                'milestones' => function ($q) {
                    $q->addSelect(['id', 'job_quote_id', 'percent', 'due_date', 'paid']);
                },
                'jobPost' => function ($q) {
                    $q->addSelect(['id', 'user_id', 'category_id'])->with(['category', 'userProfile' => function ($q) {
                        $q->addSelect(['id', 'userA_id', 'userB_id', 'title']);
                    }]);
                }]);
            }])->orderBy('created_at', 'DESC')->paginate(10);
    }
}
