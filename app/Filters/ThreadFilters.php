<?php

namespace App\Filters;

use App\User;


class ThreadFilters extends Filters {

    protected $filters = ['by', 'popular'];

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

    /**
     * Filter the query with most popular threads.
     *
     * @return void
     */
    protected function popular()
    {
        // this will remove order by constraint from query
        $this->builder->getQuery()->orders = [];

        return $this->builder->orderBy('replies_count', 'DESC');
    }

}