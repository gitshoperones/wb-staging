<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserCardAccount;
use App\Contracts\PaymentGateway;
use Illuminate\Support\Facades\Auth;
use App\Services\AssemblyPaymentGateway;

class UserCardAccountsController extends Controller
{
    public function destroy($id, PaymentGateway $paymentGateway)
    {
        $card = UserCardAccount::whereId($id)->where('user_id', Auth::id())->firstOrFail();

        $paymentGateway->deleteCardAccount($card->card_account_id);

        $card->delete();

        return redirect()->back()->with('success_message', 'Deleted successfully!');
    }
}
