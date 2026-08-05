<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(["id", "order_id", "question_id", "value"])]
class Answer extends Model
{
    protected function casts():array{
        return [
            'value' => 'array',
        ];
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
