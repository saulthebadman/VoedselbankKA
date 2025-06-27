<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klant extends Model
{
    use HasFactory;

    protected $table = 'klanten';
    protected $primaryKey = 'klant_id';
    public $timestamps = true;

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'klant_id';
    }

    /**
     * Get the value of the model's route key.
     */
    public function getRouteKey()
    {
        return $this->getAttribute($this->getRouteKeyName());
    }

    protected $casts = [
        'actief' => 'boolean',
        'aanmelddatum' => 'datetime',
    ];

    protected $fillable = [
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
        'aanmelddatum',
    ];
}
