<?php

namespace Database\Seeders;

use App\Models\AcceptedDocument;
use Illuminate\Database\Seeder;

class AcceptedDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        AcceptedDocument::create(
          ['document_type' => 'Drivers License'],
          ['document_type' => 'International Passport'],
          ['document_type' => 'Voter\'s Card'],
          ['document_type' => 'NIN'],
          ['document_type' => 'Goverment Issued Identity Card']
        );
    }
}
