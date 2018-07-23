<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email', 'avatar', 'password'];

    public static $rules = [
        'email' => 'required|email|max:190|unique:users',
        'password' => 'required|string|min:6',
        'avatar' => 'file',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * Set the user's email in lowercase.
     *
     * @param  string $email
     * @return void
     */
    public function setEmailAttribute($email)
    {
        $this->attributes['email'] = strtolower($email);
    }

    /**
     * Set the user's email in lowercase.
     *
     * @param  string $avatar
     * @return void
     */
    public function setAvatarAttribute($avatar)
    {
        $this->attributes['avatar'] = $avatar->hashName();
    }

    /**
     * Set the user's email in lowercase.
     *
     * @param  string $password
     * @return void
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = app('hash')->make($password);
    }
}
