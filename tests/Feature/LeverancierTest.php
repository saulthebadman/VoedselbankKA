<?php

use App\Models\Leverancier;
use App\Models\User;

// Test: Authenticated user can view leveranciers index
test('authenticated user can view leveranciers index', function () {
    // Arrange
    $user = User::factory()->create();
    
    Leverancier::create([
        'bedrijfsnaam' => 'Test Leverancier BV',
        'adres' => 'Teststraat 123, 1234 AB Teststad',
        'contactpersoon_naam' => 'Jan Test',
        'email' => 'jan@test.nl',
        'telefoonnummer' => '0612345678',
        'actief' => true
    ]);

    // Act
    $response = $this->actingAs($user)->get(route('leveranciers.index'));

    // Assert
    $response->assertStatus(200);
    $response->assertSee('Test Leverancier BV');
    $response->assertSee('Leveranciers Overzicht');
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

// Test: Leverancier creation requires valid data
test('leverancier creation requires valid data', function () {
    // Arrange
    $user = User::factory()->create();
    
    // Act
    $response = $this->actingAs($user)
        ->post(route('leveranciers.store'), []);

    // Assert
    $response->assertSessionHasErrors([
        'bedrijfsnaam',
        'adres',
        'contactpersoon_naam',
        'email',
        'telefoonnummer'
    ]);
});

// Test: Authenticated user can update leverancier
test('authenticated user can update leverancier', function () {
    // Arrange
    $user = User::factory()->create();
    
    $leverancier = Leverancier::create([
        'bedrijfsnaam' => 'Oude Naam BV',
        'adres' => 'Oude straat 1, 1111 AA Oudstad',
        'contactpersoon_naam' => 'Oude Contact',
        'email' => 'oude@email.nl',
        'telefoonnummer' => '0611111111',
        'actief' => true
    ]);

    $updateData = [
        'bedrijfsnaam' => 'Nieuwe Naam BV',
        'adres' => 'Nieuwe adres 789, 9876 ZX Updatestad',
        'contactpersoon_naam' => 'Updated Contact',
        'email' => 'nieuwe@email.nl',
        'telefoonnummer' => '0698765432',
        'actief' => true
    ];

    // Act
    $response = $this->actingAs($user)
        ->put(route('leveranciers.update', $leverancier), $updateData);

    // Assert
    $response->assertRedirect(route('leveranciers.index'));
    $response->assertSessionHas('success', 'Leverancier succesvol bijgewerkt!');
    
    $this->assertDatabaseHas('leveranciers', [
        'leverancier_id' => $leverancier->leverancier_id,
        'bedrijfsnaam' => 'Nieuwe Naam BV',
        'email' => 'nieuwe@email.nl'
    ]);
});

// Test: Guest cannot access leveranciers
test('guest cannot access leveranciers', function () {
    // Act
    $response = $this->get(route('leveranciers.index'));

    // Assert
    $response->assertRedirect(route('login'));
});
