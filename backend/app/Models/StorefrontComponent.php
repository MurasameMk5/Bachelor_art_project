<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(["id", "storefront_id", "type", "position", "content", "is_visible"])]
class StorefrontComponent extends Model
{
    //
}
