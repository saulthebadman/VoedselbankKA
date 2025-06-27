<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeverancierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Leverancier::create([
            'bedrijfsnaam' => 'Albert Heijn Distributie',
            'adres' => 'Provincialeweg 11, 1506 MA Zaandam',
            'contactpersoon_naam' => 'Jan de Vries',
            'email' => 'jan.devries@ah.nl',
            'telefoonnummer' => '075-6589741',
            'eerstvolgende_levering' => '2025-07-01 08:00:00',
            'actief' => true
        ]);

        \App\Models\Leverancier::create([
            'bedrijfsnaam' => 'Jumbo Supermarkten BV',
            'adres' => 'Industrieweg 1, 5466 AC Veghel',
            'contactpersoon_naam' => 'Marie van der Berg',
            'email' => 'marie.vdberg@jumbo.com',
            'telefoonnummer' => '0413-366200',
            'eerstvolgende_levering' => '2025-07-02 10:30:00',
            'actief' => true
        ]);

        \App\Models\Leverancier::create([
            'bedrijfsnaam' => 'Bakkerij de Korenwolf',
            'adres' => 'Hoofdstraat 45, 5421 CV Gemert',
            'contactpersoon_naam' => 'Piet Bakker',
            'email' => 'info@korenwolf.nl',
            'telefoonnummer' => '0492-361254',
            'eerstvolgende_levering' => '2025-07-03 07:00:00',
            'actief' => true
        ]);

        \App\Models\Leverancier::create([
            'bedrijfsnaam' => 'Boerderij Verse Groenten',
            'adres' => 'Akkerweg 23, 5431 NL Cuijk',
            'contactpersoon_naam' => 'Anna Groentemaker',
            'email' => 'anna@versegroenten.nl',
            'telefoonnummer' => '0485-123456',
            'eerstvolgende_levering' => '2025-07-04 14:00:00',
            'actief' => true
        ]);

        \App\Models\Leverancier::create([
            'bedrijfsnaam' => 'Zuivel Coöperatie Limburg',
            'adres' => 'Melkweg 12, 6001 AB Weert',
            'contactpersoon_naam' => 'Henk Melkboer',
            'email' => 'henk@zuivelcoop.nl',
            'telefoonnummer' => '0495-789123',
            'eerstvolgende_levering' => '2025-07-05 09:15:00',
            'actief' => true
        ]);

        \App\Models\Leverancier::create([
            'bedrijfsnaam' => 'Slagerij van den Berg',
            'adres' => 'Marktplein 8, 5401 GN Uden',
            'contactpersoon_naam' => 'Willem van den Berg',
            'email' => 'willem@slagerijvandenberg.nl',
            'telefoonnummer' => '0413-987654',
            'eerstvolgende_levering' => '2025-07-06 11:00:00',
            'actief' => false
        ]);
    }
}
