<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(["id", "commission_id", "storage_path", "order_position", "caption"])]
class CommissionImage extends Model
{
    //
}
