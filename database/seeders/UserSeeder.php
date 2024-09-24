<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'generic_id' => 'EVT-Admin-000001',
            'name' => 'Eventinz Admin',
            'username' => '@EtzAdmin',
            'email' => 'eventinzadmin@gmail.com',
            'password' => Hash::make('eventinzAdmin123@'),
            'is_otp_valid' => "yes",
            'role_id' => '4',
            'otp' => '100529',
            'created_at' => Carbon::now(),
            'rights' => '["view_service_list","print_list","view_users_hosts_and_vendors_list","view_details_about_hosts_and_vendors","resend_otp","view_list_of_staff_members","view_details_of_each_staff_member","edit_staff_members","edit_self_staff_account_information","add_new_staff_member","view_events_list","view_event_details","edit_event_details","view_event_type_list","add_new_event_type","edit_event_type","delete_event_type","view_event_subcategories_list","view_event_subcategory_details","edit_event_subcategory","delete_event_subcategory","view_reviews_list","view_review_details","review_edit","add_new_event_subcategory","view_categories_list","edit_category","delete_category","add_new_category","view_companies_list","view_company_details","edit_company_details","view_taxes_list","view_taxe_details","edit_taxe","delete_taxe","view_vendors_classes_list","view_vendor_class_details","view_payments_list","view_payment_details","view_subscription_list","view_subscription_details","add_new_subscription","edit_subscription","delete_subscritpion","view_contents_texts_list","view_content_text","edit_content_text","view_contents_images_list","view_content_image","edit_content_image","view_limits_list","edit_limit"]'
        ]);

        DB::table('users')->insert([
            'generic_id' => 'EVT-Admin-000002',
            'name' => 'Basit',
            'username' => '@BI',
            'email' => 'basitadmin@gmail.com',
            'password' => Hash::make('basitAdmin123@'),
            'is_otp_valid' => "yes",
            'role_id' => '3',
            'otp' => '879809',
            'created_at' => Carbon::now(),
            'rights' => '["view_service_list","print_list","view_users_hosts_and_vendors_list","view_details_about_hosts_and_vendors","resend_otp","view_list_of_staff_members","view_details_of_each_staff_member","edit_staff_members","edit_self_staff_account_information","add_new_staff_member","view_events_list","view_event_details","edit_event_details","view_event_type_list","add_new_event_type","edit_event_type","delete_event_type","view_event_subcategories_list","view_event_subcategory_details","edit_event_subcategory","delete_event_subcategory","view_reviews_list","view_review_details","review_edit","add_new_event_subcategory","view_categories_list","edit_category","delete_category","add_new_category","view_companies_list","view_company_details","edit_company_details","view_taxes_list","view_taxe_details","edit_taxe","delete_taxe","view_vendors_classes_list","view_vendor_class_details","view_payments_list","view_payment_details","view_subscription_list","view_subscription_details","add_new_subscription","edit_subscription","delete_subscritpion","view_contents_texts_list","view_content_text","edit_content_text","view_contents_images_list","view_content_image","edit_content_image","view_limits_list","edit_limit"]'
        ]);
    }
}
