<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

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

    private function getRole()
    {
        return User_role::where('user_id', Auth::user()->id)->first();
    }

    private function isAdmin()
    {
        $role = $this->getRole();
        if($role) {
            return $role->role == 'admin' ? true : false;
        }
        else {
            return false;
        }
    }

    private function isUser()
    {
        $role = $this->getRole();
        if($role) {
            return $role->role == 'user' ? true : false;
        }
        else {
            return false;
        }
    }
}
