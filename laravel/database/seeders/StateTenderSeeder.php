<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Faker\Factory as Faker;
use App\Models\Country; 
use App\Models\State; 
use App\Models\TenderType; 
use App\Models\StateNotice;
use App\Models\StateAgency; 
use App\Models\Category;  
use Illuminate\Support\Facades\DB;

class StateTenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    	$faker = Faker::create();

    	$countries = Country::pluck('country_id')->toArray();
        $states = State::pluck('state_id')->toArray();
        $tender_types = TenderType::pluck('tender_type_id')->toArray();
        $state_notices = StateNotice::pluck('state_notice_id')->toArray();
        $categories = Category::pluck('category_id')->toArray();
        $state_agencies = StateAgency::pluck('state_agency_id')->toArray();
        $state_notice_names = StateNotice::pluck('notice_name')->toArray();
        $state_agency_names = StateAgency::pluck('state_agency_name')->toArray();
        $category_names = Category::pluck('category_name')->toArray();

        $stateTenders = [];
        for ($i = 1; $i <= 1000; $i++) { 
            $stateTenders[] = [
                'tender_no' => $faker->numerify('TD-######'),
                'title' => $faker->sentence(6),
                'description' => $faker->paragraph(3),
                'opening_date' => Carbon::now()->addDays(rand(1, 30)),
                'posted_date' => now(),
                'expiry_date' => Carbon::now()->addDays(rand(31, 60)),
                'country_id' => $faker->randomElement($countries),
                'state_id' => $faker->randomElement($states),
                'tender_type_id' => $faker->randomElement($tender_types), 
                'state_notice_id' => $faker->randomElement($state_notices), 
                'category_id' => $faker->randomElement($categories), 
                'state_agency_id' => $faker->randomElement($state_agencies), 
                'tender_url' => 'http://example.com/tender/' . $i,
                'fees' => rand(1000, 5000),
                'type_of_award' => 'Award ' . $i,
                'place_of_performance' => $faker->city,
                'notice_id' => $faker->uuid,
                'description_link' => 'http://example.com/desc/' . $i,
                'category_name' => $faker->randomElement($category_names),
                'notice_name' => $faker->randomElement($state_notice_names),
                'agency_name' => $faker->randomElement($state_agency_names),
                'document_path' => '/docs/' . Str::random(10) . '.pdf',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('state_tenders')->insert($stateTenders);

        // Seed the `state_attachments` table
        $stateAttachments = [];
        foreach ($stateTenders as $index => $tender) {
            $stateAttachments[] = [
                'state_tender_id' => $index + 1,
                'attachment_name' => Str::random(10) . '.pdf',
                'attachment_size' => rand(100, 5000) . ' KB',
                'attachment_date' => Carbon::now()->subDays(rand(1, 10)),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('state_attachments')->insert($stateAttachments);

        // Seed the `state_contacts` table
        $stateContacts = [];
        foreach ($stateTenders as $index => $tender) {
            $stateContacts[] = [
                'state_tender_id' => $index + 1,
                'type' => ['Primary', 'Secondary'][rand(0, 1)],
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'title' => $faker->jobTitle,
                'full_name' => $faker->name,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('state_contacts')->insert($stateContacts);

        // Seed the `state_office_addresses` table
        $stateOfficeAddresses = [];
        foreach ($stateTenders as $index => $tender) {
            $stateOfficeAddresses[] = [
                'state_tender_id' => $index + 1,
                'city' => $faker->city,
                'state' => $faker->stateAbbr,
                'country' => $faker->countryCode,
                'zip_code' => $faker->postcode,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('state_office_addresses')->insert($stateOfficeAddresses);
    }
}
