<?php

namespace App\Http\Controllers\Admin;

use App\Models\RefundRecord;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RefundRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $refundRecords = RefundRecord::with('invoice', 'invoice.jobQuote')->paginate(10);

        return view('admin.refund.index', compact('refundRecords'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RefundRecord  $refundRecord
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RefundRecord $refundRecord)
    {
        $refundRecord->update(['status' => $request->get('status')]);

        return back()->with('success_message', "Refund record status updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RefundRecord  $refundRecord
     * @return \Illuminate\Http\Response
     */
    public function destroy(RefundRecord $refundRecord)
    {
        $refundRecord->delete();

        return back()->with('success_message', "Successfully deleted refund record");
    }
}

