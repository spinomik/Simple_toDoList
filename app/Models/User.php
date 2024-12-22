<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\PrivilegeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasUuids;

    protected static function booted()
    {
        static::retrieved(function ($user) {
            $user->load('privileges');
            $user->setAttribute('isAdmin', $user->isAdmin());
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'blocked',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'isAdmin',
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

    public function privileges()
    {
        return $this->belongsToMany(Privilege::class, 'user_privileges', 'user_id', 'privilege_id');
    }

    public function publicTokens()
    {
        return $this->hasManyThrough(PublicToken::class, Task::class);
    }

    public function isAdmin(): bool
    {
        return $this->privileges->contains('id', PrivilegeEnum::ADMIN->value);
    }

    /** 
     * @param array<PrivilegeEnum> $privileges
     * 
     * @return boolean
     */
    public function hasPrivileges(array $privileges): bool
    {
        if ($this->privileges->pluck('id')->contains(PrivilegeEnum::ADMIN->value)) {
            return true;
        }
        $privilegeValues = array_map(fn($privilege) => $privilege instanceof PrivilegeEnum ? $privilege->value : $privilege, $privileges);

        return $this->privileges->pluck('id')->intersect($privilegeValues)->isNotEmpty();
    }
}
