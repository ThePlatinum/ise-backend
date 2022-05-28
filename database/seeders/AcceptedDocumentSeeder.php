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
        $types = ['Drivers License', 'International Passport', 'Voter\'s Card', 'National Identity Number', 'Goverment Issued Identity Card'];
        foreach ($types as $type) {
            AcceptedDocument::create([
                'document_type' => $type
            ]);
        }
    }
}
