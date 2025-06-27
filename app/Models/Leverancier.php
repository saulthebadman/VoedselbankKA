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
        'bedrijfsnaam',
        'adres',
        'contactpersoon_naam',
        'email',
        'telefoonnummer',
        'eerstvolgende_levering',
        'actief'
    ];

    protected $casts = [
        'eerstvolgende_levering' => 'datetime',
        'actief' => 'boolean'
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
