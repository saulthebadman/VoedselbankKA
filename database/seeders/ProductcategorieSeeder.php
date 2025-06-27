<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductcategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Aardappelen, groente, fruit',
            'Kaas, vleeswaren',
            'Zuivel, plantaardig en eieren',
            'Bakkerij en banket',
            'Frisdrank, sappen, koffie en thee',
            'Pasta, rijst en wereldkeuken',
            'Soepen, sauzen, kruiden en olie',
            'Snoep, koek, chips en chocolade',
            'Baby, verzorging en hygiëne'
        ];

        foreach ($categories as $category) {
            \DB::table('productcategorieen')->insert([
                'omschrijving' => $category,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
