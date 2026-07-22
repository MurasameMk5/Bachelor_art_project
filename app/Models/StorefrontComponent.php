<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(["id", "storefront_id", "type", "position", "content", "is_visible"])]
class StorefrontComponent extends Model
{
    protected function casts(): array
    {
        return [
            'content' => 'array',
            'is_visible' => 'boolean',
        ];
    }
    public function storefront()
    {
        return $this->belongsTo(Storefront::class);
    }
}
