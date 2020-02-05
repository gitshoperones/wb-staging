<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Page;
use App\Models\PageSetting;
use App\Helpers\MailChimp;

class PagesController extends Controller
{
    public function faqs()
    {
        $pageSettings = PageSetting::fromPage('FAQs')->get();
        $couple = [
            'questions' => PageSetting::fromPage('FAQs Couple')->where('meta_key', 'like', '%question_%')->get(),
            'answers' => PageSetting::fromPage('FAQs Couple')->where('meta_key', 'like', '%answer_%')->get(),
        ];
        $business = [
            'questions' => PageSetting::fromPage('FAQs Business')->where('meta_key', 'like', '%question_%')->get(),
            'answers' => PageSetting::fromPage('FAQs Business')->where('meta_key', 'like', '%answer_%')->get(),
        ];

        return view('faqs.index', compact('pageSettings', 'couple', 'business'));
    }

    public function aboutUs()
    {
        $pageSettings = PageSetting::fromPage('About us')->get();

        return view('about-us.index', compact('pageSettings'));
    }

    public function fees()
    {
        $pageSettings = PageSetting::fromPage('Fees')->get();

        return view('fees.index', compact('pageSettings'));
    }

    public function listYourBusiness()
    {
        $pageSettings = PageSetting::fromPage('List Your Business')->get();

        $reasons = [
            'img' => PageSetting::fromPage('List Your Business')->where('meta_key', 'like', '%reasonimg_%')->get(),
            'title' => PageSetting::fromPage('List Your Business')->where('meta_key', 'like', '%reasontitle_%')->get()
        ];

        return view('list-your-business.index', compact('pageSettings', 'reasons'));
    }

    public function howItWorks()
    {
        $pageSettings = PageSetting::fromPage('How it works')->get();

        $how_couple = [
            'img' => PageSetting::fromPage('How it works')->where('meta_key', 'like', 'couple_section_%_img')->get(),
            'title' => PageSetting::fromPage('How it works')->where('meta_key', 'like', 'couple_section_%_title')->get(),
            'text' => PageSetting::fromPage('How it works')->where('meta_key', 'like', 'couple_section_%_text')->get()
        ];

        $how_vendor = [
            'img' => PageSetting::fromPage('How it works')->where('meta_key', 'like', 'vendor_section_%_img')->get(),
            'title' => PageSetting::fromPage('How it works')->where('meta_key', 'like', 'vendor_section_%_title')->get(),
            'text' => PageSetting::fromPage('How it works')->where('meta_key', 'like', 'vendor_section_%_text')->get()
        ];

        return view('how-it-works.index', compact('pageSettings', 'how_couple', 'how_vendor'));
    }

    public function howItWorksBusinesses()
    {
        $pageSettings = PageSetting::fromPage('How it works')->get();
        
        return view('how-it-works.index', compact('pageSettings'));
    }

    public function privacyPolicy()
    {
        $pageSettings = PageSetting::fromPage('Privacy policy')->get();

        return view('privacy-policy.index', compact('pageSettings'));
    }

    public function communityGuidelines()
    {
        $pageSettings = PageSetting::fromPage('Community guidelines')->get();

        return view('community-guidelines.index', compact('pageSettings'));
    }

    public function reviewPolicy()
    {
        $pageSettings = PageSetting::fromPage('Review Policy')->get();

        return view('review-policy.index', compact('pageSettings'));
    }

    public function contentPolicy()
    {
        $pageSettings = PageSetting::fromPage('Content Policy')->get();

        return view('content-policy.index', compact('pageSettings'));
    }

    public function checklist()
    {
        $pageSettings = PageSetting::fromPage('Planning Checklist')->get();
        
        return view('planning-checklist.index', compact('pageSettings'));
    }

    public function subscribe(Request $request)
    {
        $pageSettings = PageSetting::fromPage('Planning Checklist')->get();

        $list_id = env('MAILCHIMP_LIST_COUPLE', '6f3b22af8f');

        // ADDING THE USER TO MAILCHIMP
        $url = "https://us16.api.mailchimp.com/3.0/lists/$list_id/members/";
        $data = array(
            'email_address' => $request['email'],
            'status'        => 'subscribed',
            'merge_fields'  => array(
                'FNAME'       => $request['fname'],
                'LNAME'       => $request['lname'],
            ),
        );
        $response = (new MailChimp)->mailchimp_request($url, $data);

        // ADDING THE WEDDING CHECKLIST TAG
        (new MailChimp)->manageTag('couple', $request['email'], 'Wedding Checklist', 'active');

        $json_results = json_decode($response['result_info']);
        $title = isset($json_results->title) ? $json_results->title : null;
        $message = 'Thank you for subscribing to wedBooker\'s email newsletter.';

        if(strpos($title, "Member Exists") !== false) {
            $message = 'Email is already in our list.';
        }elseif((strpos($title, "Invalid Resource") !== false)) {
            $message = 'Invalid email.';
        }elseif((strpos($title, "Forgotten Email Not Subscribed") !== false)) {
            $message = 'Email has recently been subscribed.';
        }
        
        $download_file = isset($pageSettings->firstWhere('meta_key', "download_file")->meta_value) ? url(Storage::url($pageSettings->firstWhere('meta_key', "download_file")->meta_value)) : asset('/assets/media/WedBooker%20Wedding%20Planning%20Checklist.pdf');
        $file_name = isset($pageSettings->firstWhere('meta_key', "download_file_name")->meta_value) ? strip_tags($pageSettings->firstWhere('meta_key', "download_file_name")->meta_value) : 'WedBooker_Wedding_Planning_Checklist.pdf';

        $results = array(
            'results' => $response['result_info'],
            'response' => $response['response'],
            'errors' => $response['errors'],
            'message' => $message,
            'download' => $download_file,
            'file_name' => $file_name
        );
        
        echo json_encode($results);
    }
}
