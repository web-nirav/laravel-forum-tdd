<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    /**
     * overwrite the route model binding route key name from default primary key to whatever we pass from here
     * get the route key name for the laravel.
     *
     * @return void
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }
}
