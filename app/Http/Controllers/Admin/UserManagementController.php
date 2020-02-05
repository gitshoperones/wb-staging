<?php
namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Vendor;
use App\Models\UserNotes;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\UserReference;
use App\Models\AccountManager;
use App\Models\LocationVendor;
use Illuminate\Support\Carbon;
use App\Models\ExpertiseVendor;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\NewsLetterSubscription;
use Illuminate\Support\Facades\Storage;
use App\Repositories\VendorRepo;
use App\Helpers\MailChimp;

class UserManagementController extends Controller
{
    public function newsletterUpdate($type="add", $id = 0)
    {
        $userDetails = User::firstOrCreate(['id' => $id]);

        $list_id = $userDetails->account == 'couple' ? env('MAILCHIMP_LIST_COUPLE', '6f3b22af8f') : env('MAILCHIMP_LIST_BUSINESS', '2206f03c63');
        $email = md5($userDetails->email);
        
        $url = "https://us16.api.mailchimp.com/3.0/lists/$list_id/members/";
        $url_update = "https://us16.api.mailchimp.com/3.0/lists/$list_id/members/$email";
        $data = array(
            'email_address' => $userDetails->email,
            'status'        => ($type != "add") ? 'unsubscribed' : 'subscribed',
            'merge_fields'  => array(
                'FNAME'       => $userDetails->fname,
                'LNAME' => $userDetails->lname,
                'BNAME' => optional($userDetails->vendorProfile)->business_name,
            ),
        );

        if ($type != "add") {
            NewsLetterSubscription::whereEmail($userDetails->email)->delete();
        } else {
            NewsLetterSubscription::firstOrCreate(['email' => $userDetails->email]);
        }

        (new MailChimp)->mailchimp_request($url, $data);
        (new MailChimp)->mailchimp_request($url_update, $data, 'patch');
    }

    public function coupleUsers($status = "active", Request $request)
    {
        $statusValue = [
            'pending' => 0,
            'active' => 1,
            'rejected' => 2,
            'archive' => 3,
            'pending-email-verification' => 4,
        ];

        $type = $statusValue[$status] ?? abort(404);

        if ($request->search) {
            $userDetails = User::where('account', 'couple')
            ->leftJoin('news_letter_subscriptions', 'users.email', '=', 'news_letter_subscriptions.email')
            ->where(function ($q) use ($request, $type) {
                $q->where('users.status', $type)
                ->where('users.email', 'like', "%$request->search%")
                ->orwhere("users.fname", 'like', "%$request->search%")
                ->orwhere("users.lname", 'like', "%$request->search%");
            })

            ->select('users.*', 'news_letter_subscriptions.email as newsEmail')
            ->with([
                'vendorProfile',
                'latestNote',
                'coupleA',
            ])->paginate(env('APP_PAGINATION', 10));
        } else {
            $userDetails = User::where('account', 'couple')->with([
                'coupleA'
            ])
            ->leftJoin('news_letter_subscriptions', 'users.email', '=', 'news_letter_subscriptions.email')
            ->where('account', 'couple')
            ->where('status', $type)
            ->select('users.*', 'news_letter_subscriptions.email as newsEmail')
            ->with(['vendorProfile', 'latestNote'])->paginate(env('APP_PAGINATION', 10));
        }
        $status = str_replace('-', ' ', $status);
        $type = ucwords($status);
        $accountType = 'couple';

        return view('admin.usermanagement.index', compact('userDetails', 'type', 'accountType'));
    }

    public function vendorUsers($type = "pending", Request $request)
    {
        if ($type == "archive") {
            $stat = array(3);
        } elseif ($type == "active") {
            $stat = array(1);
        } elseif ($type == "rejected") {
            $stat = array(2);
        } else {
            $stat = array(0,4);
        }

        $q = (new User)->newQuery()->where('account', 'vendor');

        if ($request->search) {
            $q = $q->where('users.email', 'like', "%$request->search%")
            ->orWhereHas('vendorProfile', function ($q) use ($request) {
                $q->where('business_name', 'like', "%$request->search%")
                    ->orWhere('website', 'like', "%$request->search%");
            });
        }

        $userDetails = $q->whereIn('status', $stat)
            ->leftJoin('news_letter_subscriptions', 'users.email', '=', 'news_letter_subscriptions.email')
            ->select('users.*', 'news_letter_subscriptions.email as newsEmail')
            ->with([
                'manager' => function ($q) {
                    $q->with('userManager');
                },
                'vendorProfile' => function ($q) {
                    $q->addSelect(['id', 'user_id', 'business_name'])->with([
                        'expertise',
                        'reviews' => function ($q) {
                            $q->addSelect(['id', 'vendor_id', 'rating'])->whereStatus(1);
                        },
                    ]);
                }
            ])
            ->groupBy('users.id')
            ->paginate(env('APP_PAGINATION', 10));

        return view('admin.usermanagement.pending', compact('userDetails', 'type'));
    }

    public function verifyUser($id)
    {
        $user = User::where('id', $id)->firstOrFail(['id', 'status', 'email']);
        $approved = $user->update(['status' => 1]);
        return redirect('/admin/active-users');
    }

    public function deleteUser($id, $route)
    {
        $vendor = User::where('id', $id)
                    ->delete();

        if ($route === 'active') {
            return redirect('/admin/vendors/active');
        } elseif ($route === 'archived') {
            return redirect('/admin/vendors/archive');
        } elseif ($route === 'pending') {
            return redirect('/admin/vendors/pending');
        } elseif ($route === 'rejected') {
            return redirect('/admin/vendors/rejected');
        } elseif ($route === 'cactive') {
            return redirect('/admin/couple/active');
        } elseif ($route === 'cpending email verification') {
            return redirect('/admin/couple/pending-email-verification');
        } elseif ($route === 'carchived') {
            return redirect('/admin/couple/archive');
        } else {
            return redirect('/admin/vendors/pending');
        }
    }

    public function businessDetails($userId, $view = "active")
    {
        $userDetails = User::where('users.id', $userId)
        ->leftJoin('news_letter_subscriptions', 'users.email', '=', 'news_letter_subscriptions.email')
        ->select('users.*', 'news_letter_subscriptions.email as newsEmail')
        ->with([
            'vendorProfile' => function ($q) {
                $q->with(['fee' => function ($q) {
                    $q->with('fee');
                }]);
            },
            'manager' => function ($q) {
                $q->with('user');
            },
        ])->first();

        $noteDetails = UserNotes::where('user_notes.user_id', $userId)
        ->leftJoin('users', 'users.id', '=', 'user_notes.account_id')
        ->select('user_notes.*', 'users.fname', 'users.lname')
        ->orderBy('created_at', 'desc')
        ->get();

        $referenceDetails = UserReference::where('user_references.user_id', $userId)
        ->leftJoin('users', 'users.id', '=', 'user_references.account_id')
        ->select('user_references.*', 'users.fname', 'users.lname')
        ->orderBy('created_at', 'desc')
        ->get();

        $fileDetails = User::whereId($userId)->firstOrFail(['id'])->files()
            ->where('meta_key', 'verification_file')
            ->get(['meta_filename', 'meta_original_filename']);

        $adminUploadedUserFiles = User::whereId($userId)->firstOrFail(['id'])->files()
            ->where('meta_key', 'admin_uploaded_user_file')
            ->get(['meta_filename', 'meta_original_filename']);

        $vpId = 0;
        if ($userDetails->vendorProfile) {
            $vpId = $userDetails->vendorProfile->id;
            $expertiseVendor = User::where('id', $userId)->firstOrFail()->vendorProfile->expertise()->pluck('name');
            $locationVendor = LocationVendor::where('vendor_id', $vpId)
                ->join('locations', 'locations.id', '=', 'location_vendor.location_id')
                ->get();
        }

        $accountManager = User::where('account', 'admin')->get();

        $userProfile = Vendor::whereId($vpId)->with([
            'reviews' => function ($q) {
                return $q->where('status', 1);
            },
            'locations',
            'expertise',
            'propertyTypes',
            'venueCapacity',
            'propertyFeatures',
        ])->firstOrfail();

        return view('admin.usermanagement.business', compact(
            'fileDetails',
            'userDetails',
            'view',
            'expertiseVendor',
            'locationVendor',
            'noteDetails',
            'referenceDetails',
            'accountManager',
            'adminUploadedUserFiles',
            'userProfile'
        ));
    }

    public function saveReference($id, Request $request)
    {
        $details = UserReference::create([
        'user_id' => $id,
        'description' => $request->description,
        'account_id' => Auth::user()->id]);
        $name = Auth::user()->fname . " " . Auth::user()->lname;

        return response($name. ' ', 200)
        ->header('Content-Type', 'text/plain');
    }

    public function saveNote($id, Request $request)
    {
        $request->validate([
            'description' => 'required'
        ]);

        $details = UserNotes::create([
            'user_id' => $id,
            'description' => $request->description,
            'account_id' => Auth::user()->id
        ]);

        if ($details) {
            $name = Auth::user()->fname . " " . Auth::user()->lname;
            return response()->json([
                'response' => true,
                'name' => $name
            ]);
        }

    }

    public function updateUser($id, Request $request)
    {
        $user = User::where('id', $id)->firstOrFail();

        $validations = [
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|email',
            'birth_day' => 'nullable|integer',
            'birth_month' => 'nullable|integer',
            'birth_year' => 'nullable|integer',
        ];

        if ($user->account === 'vendor') {
            $validations['phone_number'] = 'nullable';
            $validations['state'] = 'required';
            $validations['postcode'] = 'required';
            $validations['abn'] = 'sometimes|nullable|digits:11';
        }

        $request->validate($validations);

        if ($request->account_manager) {
            $account = AccountManager::where('user_id', $id)->first();
            if ($account) {
                $account->fill(['accnt_mngr_id' => $request->account_manager])->save();
            } else {
                AccountManager::create(['accnt_mngr_id' => $request->account_manager,
                'user_id' => $id]);
            }
        }

        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->dob = $request->dob;

        $user->save();

        if ($user->account === 'vendor') {
            $vendor = Vendor::where('user_id', $id)->firstOrFail();
            $vendor->abn = $request->abn;
            $vendor->business_name = $request->business_name;
            $vendor->website = $request->website;
            $vendor->postcode = $request->postcode;
            $vendor->state = $request->state;

            $vendor->save();

            $request['expertises'] = json_encode($request['expertises']);
        
            $vendorRepo = new VendorRepo;
            $vendorRepo->update($request->all() + ['vendorId' => $vendor->id]);
        }

        return redirect()->back()->with('success_message', 'Updated successfully!');
    }

    public function vendorDetails($userId, $view = "active")
    {
        $userDetails = User::where('users.id', $userId)
        ->leftJoin('news_letter_subscriptions', 'users.email', '=', 'news_letter_subscriptions.email')
        ->select('users.*', 'news_letter_subscriptions.email as newsEmail')
        ->with(['vendorProfile', 'latestNote', 'coupleA'])
        ->first();

        $vpId = 0;
        if ($userDetails->vendorProfile) {
            $vpId = $userDetails->vendorProfile->id;
        }
        $categories = [];
        if(optional($userDetails->coupleA)->services) {
            $svId = json_decode($userDetails->coupleA->services);
            $categories = Category::whereIn('id', $svId)->select('name')->get();
        }

        $locationVendor = LocationVendor::where('vendor_id', $vpId)
        ->join('locations', 'locations.id', '=', 'location_vendor.location_id')
        ->get();

        $fileDetails = User::whereId($userId)->firstOrFail(['id'])->files()->where('meta_key', 'verification_file')->get(['meta_filename', 'meta_original_filename']);

        return view('admin.usermanagement.couple', compact('fileDetails', 'userDetails', 'view', 'locationVendor', 'categories'));
    }
}
