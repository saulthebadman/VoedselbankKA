<?php

use App\Models\Leverancier;
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
// LEVERANCIER CRUD TESTS
// ===========================================

// Test: Authenticated user can view leveranciers index
test('authenticated user can view leveranciers index', function () {
    // Arrange
    Leverancier::create([
        'bedrijfsnaam' => 'Test Leverancier BV',
        'adres' => 'Teststraat 123, 1234 AB Teststad',
        'contactpersoon_naam' => 'Jan Test',
        'email' => 'jan@test.nl',
        'telefoonnummer' => '0612345678',
        'actief' => true
    ]);

    // Act
    $response = $this->get(route('leveranciers.index'));

    // Assert
    $response->assertStatus(200);
    $response->assertSee('Test Leverancier BV');
    $response->assertSee('Leveranciers Overzicht');
});

// Test: Can display create leverancier form
test('can display create leverancier form', function () {
    $response = $this->get(route('leveranciers.create'));
    
    $response->assertStatus(200);
    $response->assertViewIs('leveranciers.create');
    $response->assertSee('Leverancier Toevoegen');
});

// Test: Authenticated user can create leverancier
test('authenticated user can create leverancier', function () {
    // Arrange
    $user = User::factory()->create();
    
    $leverancierData = [
        'bedrijfsnaam' => 'Nieuwe Leverancier BV',
        'adres' => 'Nieuwe straat 456, 5678 CD Nieuwestad',
        'contactpersoon_naam' => 'Maria Nieuw',
        'email' => 'maria@nieuw.nl',
        'telefoonnummer' => '0687654321',
        'eerstvolgende_levering' => '2025-07-01 10:00:00',
        'actief' => true
    ];

    // Act
    $response = $this->actingAs($user)
        ->post(route('leveranciers.store'), $leverancierData);

    // Assert
    $response->assertRedirect(route('leveranciers.index'));
    $response->assertSessionHas('success', 'Leverancier succesvol toegevoegd!');
    
    $this->assertDatabaseHas('leveranciers', [
        'bedrijfsnaam' => 'Nieuwe Leverancier BV',
        'email' => 'maria@nieuw.nl'
    ]);
});

// Test: Validates required fields when creating leverancier
test('validates required fields when creating leverancier', function () {
    $response = $this->post(route('leveranciers.store'), []);
    
    $response->assertSessionHasErrors([
        'bedrijfsnaam',
        'adres', 
        'contactpersoon_naam',
        'email',
        'telefoonnummer'
    ]);
});

// Test: Validates email format
test('validates email format when creating leverancier', function () {
    $leverancierData = [
        'bedrijfsnaam' => 'Test Supermarkt BV',
        'adres' => 'Teststraat 123',
        'contactpersoon_naam' => 'Jan Test',
        'email' => 'invalid-email-format',
        'telefoonnummer' => '0123-456789'
    ];
    
    $response = $this->post(route('leveranciers.store'), $leverancierData);
    
    $response->assertSessionHasErrors(['email']);
});

// Test: Can show specific leverancier
test('can show specific leverancier', function () {
    $leverancier = Leverancier::create([
        'bedrijfsnaam' => 'Detail Test Leverancier',
        'adres' => 'Detail straat 789',
        'contactpersoon_naam' => 'Detail Contact',
        'email' => 'detail@test.nl',
        'telefoonnummer' => '0612345679',
        'actief' => true
    ]);
    
    $response = $this->get(route('leveranciers.show', $leverancier->leverancier_id));
    
    $response->assertStatus(200);
    $response->assertViewIs('leveranciers.show');
    $response->assertSee('Detail Test Leverancier');
    $response->assertSee('Detail Contact');
});

// Test: Can display edit form
test('can display edit form for leverancier', function () {
    $leverancier = Leverancier::create([
        'bedrijfsnaam' => 'Edit Test Leverancier',
        'adres' => 'Edit straat 101',
        'contactpersoon_naam' => 'Edit Contact',
        'email' => 'edit@test.nl',
        'telefoonnummer' => '0612345680',
        'actief' => true
    ]);
    
    $response = $this->get(route('leveranciers.edit', $leverancier->leverancier_id));
    
    $response->assertStatus(200);
    $response->assertViewIs('leveranciers.edit');
    $response->assertSee($leverancier->bedrijfsnaam);
});

// Test: Can update leverancier
test('can update leverancier', function () {
    $leverancier = Leverancier::create([
        'bedrijfsnaam' => 'Oude Bedrijfsnaam',
        'adres' => 'Oude straat 123',
        'contactpersoon_naam' => 'Oude Contact',
        'email' => 'oud@test.nl',
        'telefoonnummer' => '0612345681',
        'actief' => true
    ]);
    
    $updateData = [
        'bedrijfsnaam' => 'Nieuwe Bedrijfsnaam',
        'adres' => 'Nieuwe straat 456',
        'contactpersoon_naam' => 'Nieuwe Contact',
        'email' => 'nieuw@test.nl',
        'telefoonnummer' => '0687654321',
        'eerstvolgende_levering' => '2025-08-01 14:00:00',
        'actief' => false
    ];
    
    $response = $this->put(route('leveranciers.update', $leverancier->leverancier_id), $updateData);
    
    $response->assertRedirect(route('leveranciers.index'));
    $response->assertSessionHas('success', 'Leverancier succesvol bijgewerkt!');
    
    $this->assertDatabaseHas('leveranciers', [
        'leverancier_id' => $leverancier->leverancier_id,
        'bedrijfsnaam' => 'Nieuwe Bedrijfsnaam',
        'actief' => false
    ]);
});

// Test: Can delete leverancier
test('can delete leverancier', function () {
    $leverancier = Leverancier::create([
        'bedrijfsnaam' => 'Delete Test Leverancier',
        'adres' => 'Delete straat 123',
        'contactpersoon_naam' => 'Delete Contact',
        'email' => 'delete@test.nl',
        'telefoonnummer' => '0612345682',
        'actief' => true
    ]);
    
    $response = $this->delete(route('leveranciers.destroy', $leverancier->leverancier_id));
    
    $response->assertRedirect(route('leveranciers.index'));
    $response->assertSessionHas('success', 'Leverancier succesvol verwijderd!');
    
    $this->assertDatabaseMissing('leveranciers', [
        'leverancier_id' => $leverancier->leverancier_id
    ]);
});

// ===========================================
// AUTHENTICATION & SECURITY TESTS
// ===========================================

// Test: Requires authentication
test('requires authentication to access leveranciers', function () {
    // Maak een nieuwe test instantie zonder middleware
    $freshTest = new \Tests\TestCase();
    $freshTest->setUp();
    
    $response = $freshTest->get(route('leveranciers.index'));
    
    $response->assertRedirect(route('login'));
});

// Test: Protects create route
test('protects create route from unauthenticated users', function () {
    // Maak een nieuwe test instantie zonder middleware
    $freshTest = new \Tests\TestCase();
    $freshTest->setUp();
    
    $response = $freshTest->get(route('leveranciers.create'));
    
    $response->assertRedirect(route('login'));
});

// Test: Protects store route
test('protects store route from unauthenticated users', function () {
    // Maak een nieuwe test instantie zonder middleware
    $freshTest = new \Tests\TestCase();
    $freshTest->setUp();
    
    $response = $freshTest->post(route('leveranciers.store'), [
        'bedrijfsnaam' => 'Test'
    ]);
    
    $response->assertRedirect(route('login'));
});

// ===========================================
// MODEL TESTS
// ===========================================

// Test: Leverancier model has correct fillable attributes
test('leverancier model has correct fillable attributes', function () {
    $leverancier = new Leverancier();
    
    $fillable = [
        'bedrijfsnaam',
        'adres', 
        'contactpersoon_naam',
        'email',
        'telefoonnummer',
        'eerstvolgende_levering',
        'actief'
    ];
    
    expect($leverancier->getFillable())->toEqual($fillable);
});

// Test: Can filter active leveranciers
test('can filter active leveranciers', function () {
    // Maak actieve en inactieve leveranciers
    Leverancier::create([
        'bedrijfsnaam' => 'Actieve Leverancier 1',
        'adres' => 'Actief adres 1',
        'contactpersoon_naam' => 'Actief Contact 1',
        'email' => 'actief1@test.nl',
        'telefoonnummer' => '0612345683',
        'actief' => true
    ]);
    
    Leverancier::create([
        'bedrijfsnaam' => 'Actieve Leverancier 2',
        'adres' => 'Actief adres 2',
        'contactpersoon_naam' => 'Actief Contact 2',
        'email' => 'actief2@test.nl',
        'telefoonnummer' => '0612345684',
        'actief' => true
    ]);
    
    Leverancier::create([
        'bedrijfsnaam' => 'Inactieve Leverancier',
        'adres' => 'Inactief adres',
        'contactpersoon_naam' => 'Inactief Contact',
        'email' => 'inactief@test.nl',
        'telefoonnummer' => '0612345685',
        'actief' => false
    ]);
    
    $activeLeveranciers = Leverancier::where('actief', true)->get();
    
    expect($activeLeveranciers)->toHaveCount(2);
    $activeLeveranciers->each(function ($leverancier) {
        expect($leverancier->actief)->toBeTrue();
    });
});

// ===========================================
// INTEGRATION TESTS
// ===========================================

// Test: Dashboard shows leveranciers link
test('dashboard shows leveranciers link in navigation', function () {
    $response = $this->get('/dashboard');
    
    $response->assertStatus(200);
    $response->assertSee('Leveranciers');
});

// Test: Validates unique email addresses
test('validates unique email addresses', function () {
    // Maak eerst een leverancier
    Leverancier::create([
        'bedrijfsnaam' => 'Eerste Leverancier',
        'adres' => 'Eerste adres',
        'contactpersoon_naam' => 'Eerste Contact',
        'email' => 'duplicate@test.nl',
        'telefoonnummer' => '0612345686',
        'actief' => true
    ]);
    
    // Probeer een nieuwe leverancier met hetzelfde email te maken
    $response = $this->post(route('leveranciers.store'), [
        'bedrijfsnaam' => 'Tweede Leverancier',
        'adres' => 'Tweede adres',
        'contactpersoon_naam' => 'Tweede Contact',
        'email' => 'duplicate@test.nl',
        'telefoonnummer' => '0612345687'
    ]);
    
    $response->assertSessionHasErrors(['email']);
});
