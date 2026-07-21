<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable(["name", "email", "password", "role"])]
#[Hidden(["password", "remember_token"])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            "email_verified_at" => "datetime",
            "password" => "hashed",
        ];
    }

    public function commissions()
        {
            return $this->hasMany(Commission::class, 'artist_id');
        }

        public function ordersAsArtist()
        {
            return $this->hasMany(Order::class, 'artist_id');
        }

        public function ordersAsClient()
        {
            return $this->hasMany(Order::class, 'client_id');
        }

        public function messages()
        {
            return $this->hasMany(Message::class, 'sender_id');
        }

        public function storefront()
        {
            return $this->hasOne(Storefront::class);
        }
}
