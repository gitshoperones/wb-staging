<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Search\JobQuote\JobQuoteSearchManager;

class SentQuotesController extends Controller
{
    public function index()
    {
        $filters = request()->all();
        $eagerLoads = [
            'invoice',
            'jobPost' => function ($q) {
                $q->addSelect([
                    'id', 'user_id', 'required_address', 'event_date', 'event_id', 'category_id'
                ])->with(['locations', 'event', 'category']);
            },
            'user' => function ($q) {
                $q->with(['vendorProfile' => function ($q) {
                    $q->addSelect([
                        'id', 'user_id', 'business_name', 'business_name', 'profile_avatar'
                    ]);
                }])->addSelect('id');
            }
        ];

        $jobQuotes = JobQuoteSearchManager::applyFilters($filters, $eagerLoads)
            ->paginate(12);

        return view('dashboard.vendor.sent-quotes', compact('jobQuotes'));
    }
}
