<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\PageSetting;
use App\Models\Category;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->statesComposer();
        $this->locationsComposer();
        $this->eventTypesComposer();
        $this->categoriesComposer();
        $this->loggedInUserProfile();
        $this->propertyTypesComposer();
        $this->messagesCountComposer();
        $this->locationsByStateComposer();
        $this->vendorQuotedJobsComposer();
        $this->propertyFeaturesComposer();
        $this->notificationsCountComposer();
        $this->beautySubcategoriesComposer();
        $this->websiteRequirementsComposer();
        $this->jobTimeRequirementsComposer();
        $this->couplePaymentMethodsComposer();
        $this->notificationSettingsComposer();
        $this->totalVendorWedbookerFeeComposer();

        View::composer('partials.header', function($view){
            $categories = Category::orderBy('order')->get(['id', 'name', 'icon']);
            $pageSettings = PageSetting::fromPage('Header')->get();
            $menus['guest'] = [
                'name' => PageSetting::fromPage('Header')->where('meta_key', 'like', '%guest_menu_%')->get(),
                'link' => PageSetting::fromPage('Header')->where('meta_key', 'like', '%guest_link_%')->get(),
            ];
            $menus['vendor'] = [
                'name' => PageSetting::fromPage('Header')->where('meta_key', 'like', '%vendor_menu_%')->get(),
                'link' => PageSetting::fromPage('Header')->where('meta_key', 'like', '%vendor_link_%')->get(),
            ];
            $menus['couple'] = [
                'name' => PageSetting::fromPage('Header')->where('meta_key', 'like', '%couple_menu_%')->get(),
                'link' => PageSetting::fromPage('Header')->where('meta_key', 'like', '%couple_link_%')->get(),
            ];
            $view->with(compact('pageSettings', 'menus', 'categories'));
        });

        View::composer('partials.dashboard.header', function($view){
            $categories = Category::orderBy('order')->get(['id', 'name', 'icon']);
            $pageSettings = PageSetting::fromPage('Header')->get();
            $view->with(compact('pageSettings', 'categories'));
        });

        View::composer('partials.about', function($view){
            $pageSettings = PageSetting::fromPage('Footer')->get();

            $view->with('pageSettings', $pageSettings);
        });

        View::composer('partials.key-links', function($view){
            $pageSettings = PageSetting::fromPage('Footer')->get();

            $view->with('pageSettings', $pageSettings);
        });
    }

    private function loggedInUserProfile()
    {
        return View::composer(
            [
                'dashboard.vendor.home',
                'dashboard.couple.home',
                'dashboard.couple.live-job-posts',
                'dashboard.couple.draft-job-posts',
                'partials.dashboard.sidebar-menu.couple',
                'partials.dashboard.sidebar-menu.vendor',
                'partials.dashboard.thumbnail-menu.vendor',
                'partials.dashboard.thumbnail-menu.couple',
                'partials.edit-alert',
                'profiles.edit-couple',
                'partials.dashboard.header',
                'partials.header',
                'job-quotes.edit',
                'job-posts.show',
                'notifications.index',
                'messages.index',
                'user-settings.couple.account',
                'user-settings.vendor.account',
                'user-settings.vendor.payment',
            ],
            'App\Http\ViewComposers\LoggedInUserProfile'
        );
    }

    private function notificationsCountComposer()
    {
        return View::composer(
            [
                'partials.dashboard.header',
                'partials.header',
            ],
            'App\Http\ViewComposers\NotificationsCountComposer'
        );
    }

    private function messagesCountComposer()
    {
        return View::composer(
            [
                'partials.dashboard.header',
                'partials.header',
            ],
            'App\Http\ViewComposers\MessagesCountComposer'
        );
    }

    private function vendorQuotedJobsComposer()
    {
        return View::composer(
            [
                'job-posts.index',
                'job-posts.show',
                'dashboard.vendor.job-posts',
                'dashboard.vendor.saved-jobs',
            ],
            'App\Http\ViewComposers\VendorQuotedJobsComposer'
        );
    }

    private function locationsByStateComposer()
    {
        return View::composer(
            [
                'job-posts.create',
                'job-posts.guest.create',
                'profiles.edit-vendor',
                'partials.job-posts.search-form',
                'partials.job-posts.step-1-form',
                'partials.vendor-search.search-form',
                'partials.main-banner',
                'modals.start-planning-select'
            ],
            'App\Http\ViewComposers\LocationsByStateComposer'
        );
    }

    private function locationsComposer()
    {
        return View::composer(
            [
                'job-posts.index',
                'profiles.show-vendor',
                'profiles.edit-vendor',
                'job-posts.edit',
                'dashboard.vendor.job-posts',
            ],
            'App\Http\ViewComposers\LocationsComposer'
        );
    }

    private function categoriesComposer()
    {
        return View::composer(
            [
                'dashboard.vendor.job-posts',
                'vendor-search.index',
                'profiles.edit-vendor',
                'job-posts.create',
                'job-posts.guest.create',
                'onboarding.couple',
                'job-posts.edit',
                'partials.job-posts.search-form',
                'partials.vendor-search.search-form',
                'admin.usermanagement.business'
            ],
            'App\Http\ViewComposers\CategoriesComposer'
        );
    }

    private function eventTypesComposer()
    {
        return View::composer(
            [
                'vendor-reviews.create',
                'modals.vendor-review',
                'job-posts.create',
                'job-posts.guest.create',
                'job-posts.edit',
                'onboarding.couple',
                'partials.job-posts.search-form',
            ],
            'App\Http\ViewComposers\EventTypesComposer'
        );
    }

    private function propertyTypesComposer()
    {
        return View::composer(
            [
                'job-posts.create',
                'job-posts.guest.create',
                'job-posts.edit',
                'partials.profiles.expertise',
                'partials.vendor-search.advance-vendor-filters'
            ],
            'App\Http\ViewComposers\PropertyTypesComposer'
        );
    }

    private function jobTimeRequirementsComposer()
    {
        return View::composer(
            [
                'job-posts.create',
                'job-posts.guest.create',
                'job-posts.edit',
                'partials.job-posts.advance-job-posts-filters',
            ],
            'App\Http\ViewComposers\JobTimeRequirementsComposer'
        );
    }

    private function propertyFeaturesComposer()
    {
        return View::composer(
            [
                'job-posts.create',
                'job-posts.guest.create',
                'job-posts.edit',
                'partials.profiles.expertise',
                'partials.vendor-search.advance-vendor-filters',
            ],
            'App\Http\ViewComposers\PropertyFeaturesComposer'
        );
    }

    private function statesComposer()
    {
        return View::composer(
            [
                'onboarding.vendor',
                'user-settings.vendor.account',
                'user-settings.vendor.payment',
                'user-settings.vendor.payment',
                'admin.usermanagement.business',
            ],
            'App\Http\ViewComposers\StatesComposer'
        );
    }

    private function notificationSettingsComposer()
    {
        return View::composer(
            [
                'user-settings.vendor.notifications',
                'user-settings.couple.notifications',
            ],
            'App\Http\ViewComposers\NotificationSettingsComposer'
        );
    }

    public function couplePaymentMethodsComposer()
    {
        return View::composer(
            [
                'user-settings.couple.payment',
                'partials.payments.credit-card-form'
            ],
            'App\Http\ViewComposers\CouplePaymentMethodsComposer'
        );
    }

    public function websiteRequirementsComposer()
    {
        return View::composer(
            [
                'job-posts.create',
                'job-posts.guest.create',
                'job-posts.edit',
            ],
            'App\Http\ViewComposers\WebsiteRequirementsComposer'
        );
    }

    public function beautySubcategoriesComposer()
    {
        return View::composer(
            [
                'job-posts.create',
                'job-posts.guest.create',
                'job-posts.edit',
            ],
            'App\Http\ViewComposers\BeautySubcategoriesComposer'
        );
    }

    public function totalVendorWedbookerFeeComposer()
    {
        return View::composer(
            [
                'job-quotes.create',
                'job-quotes.edit',
            ],
            'App\Http\ViewComposers\TotalVendorWedbookerFeeComposer'
        );
    }
}
