<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'password', 'avatar_id', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function avatar()
    {
        return $this->belongsTo(Avatar::class, 'avatar_id', 'id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'posted_by', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }

    public function role()
    {
        return $this->belongsTo(UserRole::class, 'role_id', 'id');
    }

    public function authorizeRoles($roles)
    {
        if (is_array($roles)) {
            return $this->hasAnyRole($roles) || abort(401, 'Unauthorized');
        }

        return $this->hasRole($roles) || abort(401, 'Unauthorized');
    }

    public function hasAnyRole($roles)
    {
        return null !== $this->roles()->whereIn('name', $roles)->first();
    }

    public function hasRole($roles)
    {
        return null !== $this->roles()->where('name', $role)->first();
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
