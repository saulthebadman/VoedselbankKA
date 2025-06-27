<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Klant;

class KlantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Klant::create([
            'gezinsnaam' => 'Familie Jansen',
            'voornaam' => 'Piet',
            'achternaam' => 'Jansen',
            'straat' => 'Hoofdstraat',
            'huisnummer' => '12',
            'postcode' => '5421AB',
            'plaats' => 'Gemert',
            'telefoonnummer' => '0492-123456',
            'email' => 'p.jansen@email.nl',
            'aantal_volwassenen' => 2,
            'aantal_kinderen' => 3,
            'aantal_babies' => 0,
            'actief' => true,
            'aanmelddatum' => now()->subDays(30),
        ]);

        Klant::create([
            'gezinsnaam' => 'Familie de Vries',
            'voornaam' => 'Maria',
            'achternaam' => 'de Vries',
            'straat' => 'Kerkstraat',
            'huisnummer' => '45',
            'postcode' => '5421CD',
            'plaats' => 'Gemert',
            'telefoonnummer' => '0492-234567',
            'email' => 'm.devries@gmail.com',
            'aantal_volwassenen' => 1,
            'aantal_kinderen' => 2,
            'aantal_babies' => 1,
            'actief' => true,
            'aanmelddatum' => now()->subDays(15),
        ]);

        Klant::create([
            'gezinsnaam' => 'Familie Bakker',
            'voornaam' => 'Jan',
            'achternaam' => 'Bakker',
            'straat' => 'Schoolstraat',
            'huisnummer' => '8',
            'postcode' => '5421EF',
            'plaats' => 'Gemert',
            'telefoonnummer' => '0492-345678',
            'email' => null,
            'aantal_volwassenen' => 2,
            'aantal_kinderen' => 1,
            'aantal_babies' => 0,
            'actief' => true,
            'aanmelddatum' => now()->subDays(45),
        ]);

        Klant::create([
            'gezinsnaam' => 'Familie Smits',
            'voornaam' => 'Anna',
            'achternaam' => 'Smits',
            'straat' => 'Molenlaan',
            'huisnummer' => '23',
            'postcode' => '5421GH',
            'plaats' => 'Gemert',
            'telefoonnummer' => '0492-456789',
            'email' => 'anna.smits@hotmail.com',
            'aantal_volwassenen' => 1,
            'aantal_kinderen' => 0,
            'aantal_babies' => 0,
            'actief' => false,
            'aanmelddatum' => now()->subDays(90),
        ]);

        Klant::create([
            'gezinsnaam' => 'Familie van der Berg',
            'voornaam' => 'Willem',
            'achternaam' => 'van der Berg',
            'straat' => 'Dorpsplein',
            'huisnummer' => '1',
            'postcode' => '5421IJ',
            'plaats' => 'Gemert',
            'telefoonnummer' => '0492-567890',
            'email' => 'w.vandenberg@yahoo.com',
            'aantal_volwassenen' => 2,
            'aantal_kinderen' => 4,
            'aantal_babies' => 1,
            'actief' => true,
            'aanmelddatum' => now()->subDays(10),
        ]);
    }
}
