<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Search\ConfirmedBooking\ConfirmedBookingSearchManager;

class ConfirmedBookingsController extends Controller
{
    public function index()
    {
        $filters = request()->all();
        $eagerLoads = [
            'jobQuote' => function ($q) {
                $q->with([
                    'milestones' => function ($q) {
                        $q->where('job_quote_milestones.paid', 0);
                    },
                    'jobPost' => function ($q) {
                        $q->addSelect([
                            'id', 'user_id', 'event_date', 'event_id', 'category_id'
                        ])->with(['locations' => function ($q) {
                            $q->addSelect(['locations.id', 'name']);
                        }, 'event' => function ($q) {
                            $q->addSelect(['events.id', 'name']);
                        }, 'category' => function ($q) {
                            $q->addSelect(['categories.id', 'name']);
                        }, 'user' => function ($q) {
                            $q->addSelect(['id'])->with(['coupleA' => function ($q) {
                                $q->addSelect(['userA_id', 'title', 'profile_avatar']);
                            }, 'coupleB' => function ($q) {
                                $q->addSelect(['userB_id', 'title', 'profile_avatar']);
                            }]);
                        }]);
                    },
                    'user' => function ($q) {
                        $q->with(['vendorProfile' => function ($q) {
                            $q->addSelect([
                                'id', 'user_id', 'business_name', 'business_name', 'profile_avatar'
                            ]);
                        }])->addSelect('id');
                    }
                ]);
            },

        ];

        $confirmedBookings = ConfirmedBookingSearchManager::applyFilters(
            $filters,
            $eagerLoads
        )->paginate(10);

        $view = sprintf('dashboard.%s.confirmed-bookings', Auth::user()->account);
        return view($view, compact('confirmedBookings'));
    }
}
