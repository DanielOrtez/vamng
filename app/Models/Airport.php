<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['icao_code', 'iata_code', 'name', 'iso_country', 'elevation_ft', 'latitude', 'longitude'])]
final class Airport extends Model
{
    //
}
