<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
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

    /**
     * overwrite the route model binding route key name from default primary key to whatever we pass from here
     * get the route key name for the laravel.
     *
     * @return void
     */
    public function getRouteKeyName()
    {
        return 'name';
    }

    public function threads()
    {
        return $this->hasMany(Thread::class)->latest();
    }

    /**
     * Get a string path for the thread.
     *
     * @return string
     */
    public function profile()
    {
        return route('profile', $this->name);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
    
}
