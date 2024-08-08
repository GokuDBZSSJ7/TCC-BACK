<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'cpf',
        'gender',
        'birthdate',
        'city_id',
        'state_id',
        'image_url',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function states()
    {
        return $this->hasOne(State::class);
    }

    public function cities()
    {
        return $this->hasOne(City::class);
    }

    public function candidate()
    {
        return $this->hasOne(Candidate::class, 'user_id', 'id');
    }

    public function getImageUrlAttribute($value): string
    {
        if ($value) {
            if (str_contains($value, 'storage')) {
                return asset($value);
            }
            return asset('storage/' . $value);
        } else {
            // return asset('images/img-padrao.jpg');
            return 'null';
        }
    }
}
