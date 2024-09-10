<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            AppSettingsTableSeeder::class,
            RoleTableSeeder::class,
            UsersTableSeeder::class,
            ModelHasRolesTableSeeder::class,
            PermissionTableSeeder::class,
            RoleHasPermissionsTableSeeder::class,
            ModelHasPermissionsTableSeeder::class,
            CountriesTableSeeder::class,
            StatesTableSeeder::class,
            CitiesTableSeeder::class,
            BookingStatusesTableSeeder::class,
            SettingsTableSeeder::class,
            ProviderTypesTableSeeder::class,
            HandymanTypesTableSeeder::class,
            PlansTableDataSeeder::class,
            StaticDataSeeder::class,
            CategoriesTableSeeder::class,
            SubCategoriesTableSeeder::class,
            ServicesTableSeeder::class,
            ServicePackagesTableSeeder::class,
            PackageServiceMappingsTableSeeder::class,
            SlidersTableSeeder::class,
            PostRequestStatusesTableSeeder::class,
            NotificationTemplateSeeder::class,
            BookingsTableSeeder::class,
            BookingRatingsTableSeeder::class,
            BookingActivitiesTableSeeder::class,
            BookingCouponMappingsTableSeeder::class,
            BookingExtraChargesTableSeeder::class,
            BookingHandymanMappingsTableSeeder::class,
            BookingPackageMappingsTableSeeder::class,
            HandymanRatingsTableSeeder::class,
            BlogsTableSeeder::class,
            PostJobRequestsTableSeeder::class,
            PostJobServiceMappingsTableSeeder::class,
            PostJobBidsTableSeeder::class,
            TaxesTableSeeder::class,
            PaymentsTableSeeder::class,
            BanksTableSeeder::class,
            ProviderPayoutsTableSeeder::class,
            DocumentsTableSeeder::class,
            ProviderDocumentsTableSeeder::class,
            ProviderTaxesTableSeeder::class,
            ProviderSlotMappingsTableSeeder::class,
            PlanLimitsTableSeeder::class,
            PaymentGatewaysTableSeeder::class,
            CouponsTableSeeder::class,
            CouponServiceMappingsTableSeeder::class,
            AppDownloadsTableSeeder::class,
            WalletsTableSeeder::class,
            WalletHistoriesTableSeeder::class,
            FrontendSettingTableSeeder::class,
            ServiceFaqsTableSeeder::class,
            ServiceAddonsTableSeeder::class,
            ServiceProofsTableSeeder::class,
            ProviderSubscriptionsTableSeeder::class,
            PaymentHistoriesTableSeeder::class,
            UserFavouriteServicesTableSeeder::class,
            SettingsTableSeeder::class,
            UserFavouriteProvidersTableSeeder::class,

        ]);
        // $this->call(BlogsTableSeeder::class);

        // i want to seed only one item to user table 
        $user = User::create( [
            'id' => 1,
            'username' => 'admin',
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'admin@admin.com',
            'phone_number' => "9876543210",
            'password' => bcrypt('admin123'),
            'user_type' => 'admin',
            'user_image' => 'uploads/users/default.png',
            'contact_number' => '9876543210',
            'country_id' => 38,
            'state_id' => 674,
            'city_id' => 10839,
            'provider_id' => NULL,
            'address' => 'Melville, SK, Canada',
            'player_id' => NULL,
            'status' => 1,
            'display_name' => 'Admin Admin',
            'providertype_id' => NULL,
            'is_featured' => 0,
            'time_zone' => 'UTC',
            'last_notification_seen' => '2023-09-29 07:47:07',
            'email_verified_at' => NULL,
            'remember_token' => NULL,
            'deleted_at' => NULL,
            'created_at' => '2021-05-28 15:59:15',
            'updated_at' => '2023-10-03 09:52:48',
            'login_type' => NULL,
            'service_address_id' => NULL,
            'uid' => NULL,
            'handymantype_id' => NULL,
            'is_subscribe' => 0,
            'social_image' => NULL,
            'is_available' => 0,
            'designation' => NULL,
            'last_online_time' => NULL,
            'slots_for_all_services' => 0,
            'known_languages' => NULL,
            'skills' => NULL,
            'description' => NULL,
            // 'profile_image' => public_path('/images/profile-images/admin/super_admin.png'),
        ]);
    }
}
