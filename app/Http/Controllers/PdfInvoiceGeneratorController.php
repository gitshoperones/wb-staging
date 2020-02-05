<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Invoice;
use App\Models\JobQuote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PdfInvoiceGeneratorController extends Controller
{
    public function create($invoiceId)
    {
        $invoice = Invoice::whereId($invoiceId)->with([
            'jobQuote' => function ($q) {
                $q->addSelect([
                    'id', 'user_id', 'job_post_id', 'message', 'specs', 'total', 'duration',
                    'tc_file_id', 'confirmed_dates', 'apply_gst', 'locked', 'status', 'amount'
                ])->with([
                    'jobPost' => function ($q) {
                        $q->addSelect([
                            'id', 'user_id', 'event_id', 'specifics', 'budget', 'event_date',
                            'category_id', 'status', 'number_of_guests', 'job_time_requirement_id',
                            'required_address'
                        ])->with([
                            'category' => function ($q) {
                                $q->addSelect(['id', 'name']);
                            },
                            'timeRequirement' => function ($q) {
                                $q->addSelect(['job_time_requirements.id', 'name']);
                            },
                            'locations' => function ($q) {
                                $q->addSelect(['locations.id', 'name']);
                            },
                            'event' => function ($q) {
                                $q->addSelect(['id', 'name']);
                            },
                            'userProfile' => function ($q) {
                                $q->addSelect(['id', 'userA_id', 'title', 'profile_avatar']);
                            }
                        ]);
                    },
                    'user' => function ($q) {
                        $q->addSelect(['id'])->with([
                            'vendorProfile' => function ($q) {
                                $q->addSelect(['id', 'user_id', 'business_name', 'profile_avatar']);
                            }
                        ]);
                    },
                    'milestones' => function ($q) {
                        $q->addSelect(['id', 'percent', 'due_date', 'desc', 'job_quote_id']);
                    },
                    'tcFile' => function ($q) {
                        $q->addSelect(['id', 'meta_filename', 'meta_original_filename']);
                    },
                    'additionalFiles' => function ($q) {
                        $q->addSelect(['files.id', 'meta_filename', 'meta_original_filename']);
                    }
                ]);
            }
        ])->firstOrFail();

        if (Gate::denies('show-invoice', $invoice)) {
            abort(403);
        }

        view()->share('invoice', $invoice);

        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);

        $pdf = PDF::loadView('pdf.invoice');

        return $pdf->stream();
    }
}
