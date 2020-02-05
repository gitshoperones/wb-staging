<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call(LocationsTableSeeder::class);
        // $this->call(CategoriesTableSeeder::class);
        // $this->call(EventsTableSeeder::class);
        // $this->call(AdminUserTypeSeeder::class);

        // $this->call(PropertyTypesTableSeeder::class);
        // $this->call(JobTimeRequirementsTableSeeder::class);
        // $this->call(PropertyFeaturesTableSeeder::class);
        // $this->call(WebsiteRequirementsTableSeeder::class);
        // $this->call(BeautySubcategoriesTableSeeder::class);
        // $this->call(ErrorMessagesTableSeeder::class);

        // $this->call(PagesTableSeeder::class);
        // $this->call(PageSettingsTableSeeder::class);
        // $this->call(EmailNotificationsTableSeeder::class);
        // $this->call(DashboardNotificationTableSeeder::class);
        // $this->call(DraftJobNotificationSeeder::class);
        // $this->call(JobUpdatedNotificationSeeder::class);
        // $this->call(JobQuoteResubmittedNotificationSeeder::class);
        // $this->call(AdminNotificationSeeder::class);
        Model::reguard();
    }
}
