<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(["id", "artist_id", "title", "base_price","description", "currency", "status", "slots_available", "estimated_days", "max_free_revisions"])]
class Commission extends Model
{
    //
}
