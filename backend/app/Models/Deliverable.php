<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(["id", "order_id", "private_storage_path", "revision_number", "status"])]
class Deliverable extends Model
{
    //
}
