<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table('aircrafts')]
#[Fillable(['registration', 'name', 'hours_flown', 'aircraft_type_id', 'hub_id', 'curr_location_id'])]
final class Aircraft extends Model
{
    /**
     * @return BelongsTo<AircraftType, $this>
     */
    public function aircraftType(): BelongsTo
    {
        return $this->belongsTo(AircraftType::class);
    }

    /**
     * @return BelongsTo<Airport, $this>
     */
    public function hub(): BelongsTo
    {
        return $this->belongsTo(Airport::class, 'hub_id');
    }

    /**
     * @return BelongsTo<Airport, $this>
     */
    public function currLocation(): BelongsTo
    {
        return $this->belongsTo(Airport::class, 'curr_location_id');
    }
}
