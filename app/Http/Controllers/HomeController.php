<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Page;
use Illuminate\Support\Facades\Storage;
use App\Models\PageSetting;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('order')->get(['id', 'name', 'icon']);
        $pageSettings = PageSetting::fromPage('Homepage')->get();
        $homepage = Page::where('name', 'Homepage')->first();

        $why = [
            'img' => PageSetting::fromPage('Homepage')->where('meta_key', 'like', '%whyimg_%')->get(),
            'title' => PageSetting::fromPage('Homepage')->where('meta_key', 'like', '%whytitle_%')->get(),
            'text' => PageSetting::fromPage('Homepage')->where('meta_key', 'like', '%whytext_%')->get(),
        ];
        $testimonials = [
            'img' => PageSetting::fromPage('Testimonials')->where('meta_key', 'like', '%testimonial_img_%')->get(),
            'title' => PageSetting::fromPage('Testimonials')->where('meta_key', 'like', '%testimonial_title_%')->get(),
            'text' => PageSetting::fromPage('Testimonials')->where('meta_key', 'like', '%testimonial_text_%')->get(),
        ];
        return view('home.index', compact('categories', 'pageSettings', 'why', 'testimonials', 'homepage'));
    }
}
