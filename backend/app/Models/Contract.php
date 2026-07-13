<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(["id", "order_id", "unique_reference", "answers_snapshot", "is_accepted_by_client", "is_accepted_by_artist", "signed_at"])]
class Contract extends Model
{
    //
}
