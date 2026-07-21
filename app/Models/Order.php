<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(["id", "artist_id", "client_id", "base_price", "final_price", "max_free_revision_count", "current_revision_count", "invoice_number", "invoice_generated_at"])]
class Order extends Model
{
    public function artist()
    {
        return $this->belongsTo(User::class, 'artist_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function commission()
    {
        return $this->belongsTo(Commission::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function contract()
    {
        return $this->hasOne(Contract::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function escrow()
    {
        return $this->hasOne(Escrow::class);
    }

    public function deliverables()
    {
        return $this->hasMany(Deliverable::class);
    }
}
