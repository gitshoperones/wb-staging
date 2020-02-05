<?php

namespace App\Http\Controllers\Admin;

use App\Models\Fee;
use App\Models\Vendor;
use App\Models\VendorFee;
use Illuminate\Http\Request;
use App\Contracts\PaymentGateway;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateFeeRequest;

class FeesController extends Controller
{
    public function index()
    {
        $fees = Fee::paginate(10);

        return view('admin.fees.index', compact('fees'));
    }

    public function create()
    {
        $feeTypes = (new Fee)->getFeeTypes();
        $payer = [
            'seller' => 'Business',
            'buyer' => 'Couple',
            //'cc',
            //'int_wire'
        ];

        return view('admin.fees.create', compact('feeTypes', 'payer'));
    }

    public function store(CreateFeeRequest $request, PaymentGateway $assemblyPaymentGateway)
    {
        $request->merge(['amount' => $request->percent * 100]);
        $request->merge(['fee_type_id' => 2]);

        $fee = $assemblyPaymentGateway->createFee($request->only([
            'name', 'fee_type_id', 'amount', 'cap', 'min', 'payer'
        ]));

        $fee = Fee::create($request->only([
            'name', 'fee_type_id', 'amount', 'type'
        ]) + ['gateway_fee_id' => $fee['id']]);

        if ($request->type === 'default') {
            if ($request->override_custom_fee && $request->override_custom_fee === 'yes') {
                $feeQuery = Fee::where('id', '<>', $fee->id);
            } else {
                $feeQuery = Fee::where('id', '<>', $fee->id)->where('type', 'default');
            }

            $feeQuery->update(['status' => 0]);
            $affectedFeeIds = $feeQuery->get(['id'])->pluck('id');

            VendorFee::whereIn('fee_id', $affectedFeeIds)->update(['fee_id' => $fee->id]);
        }

        return redirect()->back()->with('success_message', 'Fee created successfully!');
    }

    public function edit($feeId)
    {
        $fee = Fee::whereId($feeId)->firstOrFail();

        return view('admin.fees.edit', compact('fee'));
    }

    public function update($feeId, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'percent' => 'required',
        ]);

        Fee::whereId($feeId)->firstOrFail()
            ->fill(['name' => $request->name, 'amount' => $request->percent])->save();

        return redirect()->back()->with('success_message', 'Fee updated successfully!');
    }

    public function destroy($feeId)
    {
        Fee::whereId($feeId)->delete();

        return redirect()->back()->with('success_message', 'Fee deleted successfully!');
    }
}
