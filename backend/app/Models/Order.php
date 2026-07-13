<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(["id", "artist_id", "client_id", "base_price", "final_price", "max_free_revision_count", "current_revision_count", "invoice_number", "artist_name", "client_name", "invoice_generated_at"])]
class Order extends Model
{
    //
}
