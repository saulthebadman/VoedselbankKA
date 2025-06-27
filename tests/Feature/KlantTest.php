<?php

use App\Models\Klant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Disable middleware voor tests (zoals CSRF)
    $this->withoutMiddleware();
    
    // Maak een test gebruiker aan voor authenticatie
    $this->user = User::factory()->create([
        'email' => 'test@voedselbank.nl'
    ]);
    
    // Authenticeer de gebruiker
    $this->actingAs($this->user);
});

// ===========================================
// KLANT CRUD TESTS
// ===========================================

// Test: Authenticated user can view klanten index
test('authenticated user can view klanten index', function () {
    // Arrange
    Klant::create([
        'voornaam' => 'Jan',
        'achternaam' => 'Test',
        'gezinsnaam' => 'Familie Test',
        'straat' => 'Teststraat',
        'huisnummer' => '123',
        'postcode' => '1234 AB',
        'plaats' => 'Teststad',
        'telefoonnummer' => '0612345678',
        'email' => 'jan.test@email.nl',
        'aantal_volwassenen' => 2,
        'aantal_kinderen' => 1,
        'aantal_babies' => 0,
        'actief' => true,
        'aanmelddatum' => now()
    ]);

    // Act
    $response = $this->get(route('klant.index'));

    // Assert
    $response->assertStatus(200);
    $response->assertSee('Familie Test');
    $response->assertSee('Klanten Overzicht');
});

// Test: Can display create klant form
test('can display create klant form', function () {
    $response = $this->get(route('klant.create'));
    
    $response->assertStatus(200);
    $response->assertViewIs('klant.create');
    $response->assertSee('Nieuwe Klant Toevoegen');
});

// Test: Authenticated user can create klant
test('authenticated user can create klant', function () {
    // Arrange
    $klantData = [
        'voornaam' => 'Maria',
        'achternaam' => 'Nieuw',
        'straat' => 'Nieuwe straat',
        'huisnummer' => '456',
        'postcode' => '5678 CD',
        'plaats' => 'Nieuwestad',
        'telefoonnummer' => '0687654321',
        'email' => 'maria@nieuw.nl',
        'aantal_volwassenen' => 1,
        'aantal_kinderen' => 2,
        'aantal_babies' => 1,
        'actief' => 1
    ];

    // Act
    $response = $this->post(route('klant.store'), $klantData);

    // Assert
    $response->assertRedirect(route('klant.index'));
    $response->assertSessionHas('success_create');
    
    $this->assertDatabaseHas('klanten', [
        'voornaam' => 'Maria',
        'achternaam' => 'Nieuw',
        'gezinsnaam' => 'Familie Nieuw',
        'email' => 'maria@nieuw.nl'
    ]);
});

// Test: Validates required fields when creating klant
test('validates required fields when creating klant', function () {
    $response = $this->post(route('klant.store'), []);
    
    $response->assertSessionHasErrors([
        'voornaam',
        'achternaam',
        'straat',
        'huisnummer',
        'postcode',
        'plaats',
        'telefoonnummer',
        'aantal_volwassenen'
    ]);
});

// Test: Validates email format
test('validates email format when creating klant', function () {
    $klantData = [
        'voornaam' => 'Test',
        'achternaam' => 'Klant',
        'straat' => 'Teststraat',
        'huisnummer' => '123',
        'postcode' => '1234 AB',
        'plaats' => 'Teststad',
        'telefoonnummer' => '0123456789',
        'email' => 'invalid-email-format',
        'aantal_volwassenen' => 1,
        'aantal_kinderen' => 0,
        'aantal_babies' => 0
    ];
    
    $response = $this->post(route('klant.store'), $klantData);
    
    $response->assertSessionHasErrors(['email']);
});

// Test: Validates minimum aantal_volwassenen
test('validates minimum aantal_volwassenen', function () {
    $klantData = [
        'voornaam' => 'Test',
        'achternaam' => 'Klant',
        'straat' => 'Teststraat',
        'huisnummer' => '123',
        'postcode' => '1234 AB',
        'plaats' => 'Teststad',
        'telefoonnummer' => '0123456789',
        'aantal_volwassenen' => 0, // Te laag!
        'aantal_kinderen' => 1,
        'aantal_babies' => 0
    ];
    
    $response = $this->post(route('klant.store'), $klantData);
    
    $response->assertSessionHasErrors(['aantal_volwassenen']);
});

// Test: Can show specific klant
test('can show specific klant', function () {
    $klant = Klant::create([
        'voornaam' => 'Detail',
        'achternaam' => 'Test',
        'gezinsnaam' => 'Familie Test',
        'straat' => 'Detail straat',
        'huisnummer' => '789',
        'postcode' => '9876 ZY',
        'plaats' => 'Detailstad',
        'telefoonnummer' => '0612345679',
        'email' => 'detail@test.nl',
        'aantal_volwassenen' => 2,
        'aantal_kinderen' => 0,
        'aantal_babies' => 1,
        'actief' => true,
        'aanmelddatum' => now()
    ]);
    
    $response = $this->get(route('klant.show', $klant));
    
    $response->assertStatus(200);
    $response->assertViewIs('klant.show');
    $response->assertSee('Familie Test');
    $response->assertSee('Detail Test');
});

// Test: Can display edit form
test('can display edit form for klant', function () {
    $klant = Klant::create([
        'voornaam' => 'Edit',
        'achternaam' => 'Test',
        'gezinsnaam' => 'Familie Test',
        'straat' => 'Edit straat',
        'huisnummer' => '101',
        'postcode' => '1010 AB',
        'plaats' => 'Editstad',
        'telefoonnummer' => '0612345680',
        'email' => 'edit@test.nl',
        'aantal_volwassenen' => 1,
        'aantal_kinderen' => 1,
        'aantal_babies' => 0,
        'actief' => true,
        'aanmelddatum' => now()
    ]);
    
    $response = $this->get(route('klant.edit', $klant));
    
    $response->assertStatus(200);
    $response->assertViewIs('klant.edit');
    $response->assertSee($klant->voornaam);
    $response->assertSee($klant->achternaam);
});

// Test: Can update klant
test('can update klant', function () {
    $klant = Klant::create([
        'voornaam' => 'Oude',
        'achternaam' => 'Naam',
        'gezinsnaam' => 'Familie Naam',
        'straat' => 'Oude straat',
        'huisnummer' => '123',
        'postcode' => '1234 AB',
        'plaats' => 'Oudstad',
        'telefoonnummer' => '0612345681',
        'email' => 'oud@test.nl',
        'aantal_volwassenen' => 1,
        'aantal_kinderen' => 0,
        'aantal_babies' => 0,
        'actief' => true,
        'aanmelddatum' => now()
    ]);
    
    $updateData = [
        'voornaam' => 'Nieuwe',
        'achternaam' => 'Naam',
        'straat' => 'Nieuwe straat',
        'huisnummer' => '456',
        'postcode' => '5678 CD',
        'plaats' => 'Nieuwstad',
        'telefoonnummer' => '0687654321',
        'email' => 'nieuw@test.nl',
        'aantal_volwassenen' => 2,
        'aantal_kinderen' => 1,
        'aantal_babies' => 1,
        'actief' => 1 // Checkbox waarde
    ];
    
    $response = $this->put(route('klant.update', $klant), $updateData);
    
    $response->assertRedirect(route('klant.index'));
    $response->assertSessionHas('success_edit');
    
    $this->assertDatabaseHas('klanten', [
        'klant_id' => $klant->klant_id,
        'voornaam' => 'Nieuwe',
        'gezinsnaam' => 'Familie Naam', // Auto-generated
        'actief' => true
    ]);
});

// Test: Can update actief status with checkbox
test('can update actief status with checkbox', function () {
    $klant = Klant::create([
        'voornaam' => 'Test',
        'achternaam' => 'Actief',
        'gezinsnaam' => 'Familie Actief',
        'straat' => 'Test straat',
        'huisnummer' => '123',
        'postcode' => '1234 AB',
        'plaats' => 'Teststad',
        'telefoonnummer' => '0612345681',
        'aantal_volwassenen' => 1,
        'aantal_kinderen' => 0,
        'aantal_babies' => 0,
        'actief' => true,
        'aanmelddatum' => now()
    ]);
    
    // Test: Checkbox niet aangevinkt = actief wordt false
    $updateData = [
        'voornaam' => 'Test',
        'achternaam' => 'Actief',
        'straat' => 'Test straat',
        'huisnummer' => '123',
        'postcode' => '1234 AB',
        'plaats' => 'Teststad',
        'telefoonnummer' => '0612345681',
        'aantal_volwassenen' => 1,
        'aantal_kinderen' => 0,
        'aantal_babies' => 0,
        // 'actief' key ontbreekt = checkbox niet aangevinkt
    ];
    
    $response = $this->put(route('klant.update', $klant), $updateData);
    
    $response->assertRedirect(route('klant.index'));
    
    $this->assertDatabaseHas('klanten', [
        'klant_id' => $klant->klant_id,
        'actief' => false // Should be false now
    ]);
});

// ===========================================
// AUTHENTICATION & SECURITY TESTS
// ===========================================

// Test: Requires authentication
test('requires authentication to access klanten', function () {
    // Log uit de huidige gebruiker
    auth()->logout();
    
    $response = $this->get(route('klant.index'));
    
    $response->assertRedirect(route('login'));
});

// Test: Protects create route
test('protects create route from unauthenticated users', function () {
    // Log uit de huidige gebruiker
    auth()->logout();
    
    $response = $this->get(route('klant.create'));
    
    $response->assertRedirect(route('login'));
});

// ===========================================
// MODEL TESTS
// ===========================================

// Test: Klant model has correct fillable attributes
test('klant model has correct fillable attributes', function () {
    $klant = new Klant();
    
    $fillable = [
        'gezinsnaam',
        'voornaam',
        'achternaam',
        'straat',
        'huisnummer',
        'postcode',
        'plaats',
        'telefoonnummer',
        'email',
        'aantal_volwassenen',
        'aantal_kinderen',
        'aantal_babies',
        'actief',
        'aanmelddatum'
    ];
    
    expect($klant->getFillable())->toEqual($fillable);
});

// Test: Can filter active klanten
test('can filter active klanten', function () {
    // Maak actieve en inactieve klanten
    Klant::create([
        'voornaam' => 'Actieve',
        'achternaam' => 'Klant1',
        'gezinsnaam' => 'Familie Klant1',
        'straat' => 'Actief adres',
        'huisnummer' => '1',
        'postcode' => '1234 AB',
        'plaats' => 'Actiefstad',
        'telefoonnummer' => '0612345683',
        'aantal_volwassenen' => 1,
        'aantal_kinderen' => 0,
        'aantal_babies' => 0,
        'actief' => true,
        'aanmelddatum' => now()
    ]);
    
    Klant::create([
        'voornaam' => 'Actieve',
        'achternaam' => 'Klant2',
        'gezinsnaam' => 'Familie Klant2',
        'straat' => 'Actief adres',
        'huisnummer' => '2',
        'postcode' => '1234 AB',
        'plaats' => 'Actiefstad',
        'telefoonnummer' => '0612345684',
        'aantal_volwassenen' => 2,
        'aantal_kinderen' => 1,
        'aantal_babies' => 0,
        'actief' => true,
        'aanmelddatum' => now()
    ]);
    
    Klant::create([
        'voornaam' => 'Inactieve',
        'achternaam' => 'Klant',
        'gezinsnaam' => 'Familie Klant',
        'straat' => 'Inactief adres',
        'huisnummer' => '3',
        'postcode' => '5678 CD',
        'plaats' => 'Inactiefstad',
        'telefoonnummer' => '0612345685',
        'aantal_volwassenen' => 1,
        'aantal_kinderen' => 0,
        'aantal_babies' => 0,
        'actief' => false,
        'aanmelddatum' => now()
    ]);
    
    $actieveKlanten = Klant::where('actief', true)->get();
    
    expect($actieveKlanten)->toHaveCount(2);
    $actieveKlanten->each(function ($klant) {
        expect($klant->actief)->toBeTrue();
    });
});

// ===========================================
// BUSINESS LOGIC TESTS
// ===========================================

// Test: Cannot delete active klant
test('cannot delete active klant', function () {
    $klant = Klant::create([
        'voornaam' => 'Actieve',
        'achternaam' => 'TestKlant',
        'gezinsnaam' => 'Familie TestKlant',
        'straat' => 'Actief adres',
        'huisnummer' => '123',
        'postcode' => '1234 AB',
        'plaats' => 'Actiefstad',
        'telefoonnummer' => '0612345688',
        'aantal_volwassenen' => 1,
        'aantal_kinderen' => 0,
        'aantal_babies' => 0,
        'actief' => true, // ACTIEF
        'aanmelddatum' => now()
    ]);
    
    $response = $this->delete(route('klant.destroy', $klant));
    
    $response->assertRedirect(route('klant.index'));
    $response->assertSessionHas('error'); // Should show error message
    
    // Controleer dat klant nog bestaat (niet verwijderd)
    $this->assertDatabaseHas('klanten', [
        'klant_id' => $klant->klant_id
    ]);
});

// Test: Can delete inactive klant  
test('can delete inactive klant', function () {
    $klant = Klant::create([
        'voornaam' => 'Inactieve',
        'achternaam' => 'TestKlant',
        'gezinsnaam' => 'Familie TestKlant',
        'straat' => 'Inactief adres',
        'huisnummer' => '123',
        'postcode' => '1234 AB',
        'plaats' => 'Inactiefstad',
        'telefoonnummer' => '0612345689',
        'aantal_volwassenen' => 1,
        'aantal_kinderen' => 0,
        'aantal_babies' => 0,
        'actief' => false, // INACTIEF
        'aanmelddatum' => now()
    ]);
    
    // Controleer dat klant echt inactief is
    expect($klant->actief)->toBeFalse();
    
    $response = $this->delete(route('klant.destroy', $klant));
    
    $response->assertRedirect(route('klant.index'));
    $response->assertSessionHas('success_delete');
    
    // Controleer dat klant verwijderd is
    $this->assertDatabaseMissing('klanten', [
        'klant_id' => $klant->klant_id
    ]);
});

// Test: Auto-generates gezinsnaam
test('auto generates gezinsnaam from achternaam', function () {
    $klantData = [
        'voornaam' => 'Jan',
        'achternaam' => 'Pietersen',
        'straat' => 'Teststraat',
        'huisnummer' => '123',
        'postcode' => '1234 AB',
        'plaats' => 'Teststad',
        'telefoonnummer' => '0612345678',
        'aantal_volwassenen' => 1,
        'aantal_kinderen' => 0,
        'aantal_babies' => 0,
        'actief' => 1
    ];

    $response = $this->post(route('klant.store'), $klantData);

    $response->assertRedirect(route('klant.index'));
    
    $this->assertDatabaseHas('klanten', [
        'achternaam' => 'Pietersen',
        'gezinsnaam' => 'Familie Pietersen'
    ]);
});

// Test: Calculates total gezinsgrootte correctly
test('calculates total gezinsgrootte correctly', function () {
    $klant = Klant::create([
        'voornaam' => 'Test',
        'achternaam' => 'Familie',
        'gezinsnaam' => 'Familie Familie',
        'straat' => 'Test straat',
        'huisnummer' => '123',
        'postcode' => '1234 AB',
        'plaats' => 'Teststad',
        'telefoonnummer' => '0612345678',
        'aantal_volwassenen' => 2,
        'aantal_kinderen' => 3,
        'aantal_babies' => 1,
        'actief' => true,
        'aanmelddatum' => now()
    ]);
    
    $totaal = $klant->aantal_volwassenen + $klant->aantal_kinderen + $klant->aantal_babies;
    
    expect($totaal)->toBe(6);
});

// ===========================================
// INTEGRATION TESTS
// ===========================================

// Test: Dashboard shows klanten link
test('dashboard shows klanten link in navigation', function () {
    $response = $this->get('/dashboard');
    
    $response->assertStatus(200);
    $response->assertSee('Klanten');
});

// Test: Empty state shows correct message
test('empty state shows correct message when no klanten exist', function () {
    // Zorg dat er geen klanten zijn
    Klant::query()->delete();
    
    $response = $this->get(route('klant.index'));
    
    $response->assertStatus(200);
    $response->assertSee('Er zijn momenteel geen klanten geregistreerd');
    $response->assertSee('Voeg je eerste klant toe');
});

// Test: Shows klanten count correctly
test('shows klanten count correctly', function () {
    // Maak 3 klanten aan
    Klant::factory()->count(3)->create();
    
    $response = $this->get(route('klant.index'));
    
    $response->assertStatus(200);
    // Should show the table with klanten
    $response->assertDontSee('Er zijn momenteel geen klanten geregistreerd');
});

// ===========================================
// VALIDATION EDGE CASES
// ===========================================

// Test: Handles optional email field correctly
test('handles optional email field correctly', function () {
    $klantData = [
        'voornaam' => 'Geen',
        'achternaam' => 'Email',
        'straat' => 'Test straat',
        'huisnummer' => '123',
        'postcode' => '1234 AB',
        'plaats' => 'Teststad',
        'telefoonnummer' => '0612345678',
        'aantal_volwassenen' => 1,
        'aantal_kinderen' => 0,
        'aantal_babies' => 0,
        'actief' => 1
        // email field omitted
    ];

    $response = $this->post(route('klant.store'), $klantData);

    $response->assertRedirect(route('klant.index'));
    
    $this->assertDatabaseHas('klanten', [
        'voornaam' => 'Geen',
        'achternaam' => 'Email',
        'email' => null
    ]);
});

// Test: Validates negative numbers for family size
test('validates negative numbers for family size', function () {
    $klantData = [
        'voornaam' => 'Test',
        'achternaam' => 'Negative',
        'straat' => 'Test straat',
        'huisnummer' => '123',
        'postcode' => '1234 AB',
        'plaats' => 'Teststad',
        'telefoonnummer' => '0612345678',
        'aantal_volwassenen' => 1,
        'aantal_kinderen' => -1, // Negative!
        'aantal_babies' => 0,
        'actief' => 1
    ];

    $response = $this->post(route('klant.store'), $klantData);
    
    $response->assertSessionHasErrors(['aantal_kinderen']);
});
