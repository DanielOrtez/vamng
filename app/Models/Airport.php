<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['icao', 'iata', 'name', 'iso_2_country', 'elevation_ft', 'latitude', 'longitude'])]
final class Airport extends Model
{
    //
}
