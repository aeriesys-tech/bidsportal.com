<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FederalTender; 
use App\Models\Country; 
use App\Models\State; 
use App\Models\TenderType; 
use App\Models\FederalNotice; 
use App\Models\Category; 
use App\Models\FederalAgency; 
use App\Models\SetAside; 
use App\Models\Naics; 
use App\Models\Psc; 
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use App\Models\FederalContact;
use App\Models\FederalOfficeAddress;
use App\Models\FederalAttachment;

class FederalTenderSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Fetch valid IDs from foreign key tables
        $countryIds = Country::pluck('country_id')->toArray();
        $stateIds = State::pluck('state_id')->toArray();
        $tenderTypeIds = TenderType::pluck('tender_type_id')->toArray();
        $federalNoticeIds = FederalNotice::pluck('federal_notice_id')->toArray();
        $categoryIds = Category::pluck('category_id')->toArray();
        $federalAgencyIds = FederalAgency::pluck('federal_agency_id')->toArray();
        $setAsideIds = SetAside::pluck('set_aside_id')->toArray();
        $naicsIds = Naics::pluck('naics_id')->toArray();
        $pscIds = Psc::pluck('psc_id')->toArray();

        // Generate 10 fake FederalTender records
        foreach (range(1, 500000) as $index) {
            $federal_tender = FederalTender::create([
                'notice_id' => $faker->uuid, // Unique identifier
                'tender_no' => $faker->numerify('TD-######'), // Random tender number
                'title' => $faker->sentence(6), // Random title
                'description' => $faker->paragraph(3), // Random description
                'opening_date' => $faker->dateTimeBetween('now', '+1 month'), // Random opening date
                'posted_date' => now(), // Current date as posted date
                'expiry_date' => $faker->dateTimeBetween('+1 month', '+6 months'), // Random expiry date
                'country_id' => $faker->randomElement($countryIds), // Valid country ID
                'state_id' => $faker->randomElement($stateIds), // Valid state ID
                'tender_type_id' => $faker->randomElement($tenderTypeIds), // Valid tender type ID
                'federal_notice_id' => $faker->randomElement($federalNoticeIds), // Valid federal notice ID
                'category_id' => $faker->randomElement($categoryIds), // Valid category ID
                'federal_agency_id' => $faker->randomElement($federalAgencyIds), // Valid federal agency ID
                'set_aside_id' => $faker->randomElement($setAsideIds), // Valid set aside ID
                'naics_id' => $faker->randomElement($naicsIds), // Valid NAICS ID
                'psc_id' => $faker->randomElement($pscIds), // Valid PSC ID
                'tender_url' => $faker->url, // Random URL
                'fees' => $faker->randomFloat(2, 0, 1000), // Random fees
                'type_of_award' => $faker->word, // Random type of award
                'place_of_performance' => $faker->city, // Random place of performance
                'description_link' => $faker->url, // Random URL for description
                'category_name' => $faker->word, // Random category name
                'agency_name' => $faker->company, // Random agency name
            ]);

            // Insert related FederalContact
            FederalContact::create([
                'federal_tender_id' => $federal_tender->federal_tender_id,
                'type' => $faker->randomElement(['Primary', 'Secondary']),
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'title' => $faker->jobTitle,
                'full_name' => $faker->name,
            ]);

            // Insert related FederalOfficeAddress
            FederalOfficeAddress::updateOrCreate(
                ['federal_tender_id' => $federal_tender->federal_tender_id],
                [
                    'city' => $faker->city,
                    'state' => $faker->stateAbbr,
                    'country' => $faker->countryCode,
                    'zip_code' => $faker->postcode,
                ]
            );

            // Insert related FederalAttachment (assume multiple attachments per tender)
            foreach (range(1, 3) as $key) {
                FederalAttachment::updateOrCreate(
                    [   'federal_tender_id' => $federal_tender->federal_tender_id,
                        'attachment_name' => 'Document_' . $key . '.pdf'
                    ],
                    [
                        'attachment_size' => $faker->randomFloat(2, 1, 20), // Fake file size in MB
                        'attachment_date' => $faker->dateTimeBetween('-1 month', 'now'),
                    ]
                );
            }
        }
    }
}
