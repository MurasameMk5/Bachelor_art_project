<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(["id", "artist_id", "component_id", "title", "base_price","description", "currency", "status", "slots_available", "estimated_days", "max_free_revisions"])]
class Commission extends Model
{
    public function artist()
    {
        return $this->belongsTo(User::class, 'artist_id');
    }
    public function component() {
        return $this->belongsTo(StorefrontComponent::class, 'component_id');
    }

    public function images()
    {
        return $this->hasMany(CommissionImage::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);

    }
}
