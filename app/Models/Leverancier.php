<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Leverancier extends Model
{
    use HasFactory;
    
    protected $table = 'leveranciers';
    protected $primaryKey = 'leverancier_id';
    
    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'leverancier_id';
    }
    
    protected $fillable = [
        'leveranciernummer',
        'bedrijfsnaam',
        'adres',
        'contactpersoon_naam',
        'email',
        'telefoonnummer',
        'leveranciertype',
        'opmerking',
        'eerstvolgende_levering',
        'isactief'
    ];

    protected $casts = [
        'eerstvolgende_levering' => 'datetime',
        'isactief' => 'boolean',
        'datum_aangemaakt' => 'datetime',
        'datum_gewijzigd' => 'datetime'
    ];

    // Custom timestamps columns
    const CREATED_AT = 'datum_aangemaakt';
    const UPDATED_AT = 'datum_gewijzigd';

    // Leveranciertype opties volgens docent eisen
    const LEVERANCIERTYPE_OPTIONS = [
        'supermarkten' => 'Supermarkten',
        'groothandelaars' => 'Groothandelaars', 
        'boeren' => 'Boeren'
    ];

    // Relaties
    public function leveringen()
    {
        return $this->hasMany(Levering::class, 'leverancier_id', 'leverancier_id');
    }

    public function producten()
    {
        return $this->hasMany(Product::class, 'leverancier_id', 'leverancier_id');
    }
}
