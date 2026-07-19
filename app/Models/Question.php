<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(["id", "commission_id", "text", "field_type"])]
class Question extends Model
{
    //
}
