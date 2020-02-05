<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use App\Repositories\FileRepo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\UpdateUserSettingsRequest;
use App\Helpers\RedactInfo;

class UserSettingsController extends Controller
{
    public function index($setting = 'account')
    {
        $user = Auth::user();

        if (!$user->isDoneOnboarding()) {
            abort(403, 'unfinished-onboarding');
        }

        $paymentSetting = $user->vendorProfile ? $user->vendorProfile->paymentSetting : null;
        $tcFiles = $user->files()->where('meta_key', 'tc')->get(['id', 'meta_filename', 'meta_original_filename']);

        $view = sprintf('user-settings.%s.%s', $user->account, $setting);
        
        // $paymentSetting = app('impersonate')->isImpersonating() ? $this->redactInfo($paymentSetting) : $paymentSetting ;
        $paymentSetting = $paymentSetting ? (new RedactInfo)->redactInfo($paymentSetting) : null;

        return view($view, compact(
            'setting',
            'user',
            'paymentSetting',
            'tcFiles'
        ));
    }
}
