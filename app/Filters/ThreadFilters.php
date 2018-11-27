<?php

namespace App\Filters;

use App\User;


class ThreadFilters extends Filters {

    protected $filters = ['by'];

    /**
     * Filter the query by given username
     *
     * @param string $username
     * @return void
     */
    protected function by($username)
    {
        $user = User::whereName($username)->firstOrFail();
        
        return $this->builder->where('user_id', $user->id);
    }

}