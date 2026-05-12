<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\RankFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'hours', 'image_url'])]
final class Rank extends Model
{
    /** @use HasFactory<RankFactory> */
    use HasFactory;
}
