<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(["id", "order_id", "stripe_payment_intent_id", "funds_status", "held_at", "released_at"])]
class Escrow extends Model
{
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
