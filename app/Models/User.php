<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Get the recipes for the user.
     */
    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }

    /**
     * Get the partners for the user.
     */
    public function partners()
    {
        return $this->hasMany(Partner::class);
    }

    /**
     * Scope a query to only include user of a given email.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $email
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEmail($query, $email)
    {
        return $query->where('email', $email);
    }
}
