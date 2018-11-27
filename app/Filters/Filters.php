<?php

namespace App\Filters;

use Illuminate\Http\Request;


abstract class Filters {

    protected $request, $builder;

    protected $filters = [];


    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function apply($builder)
    {
        $this->builder = $builder;

        foreach($this->getFilters() as $filter => $value){
            if(method_exists($this, $filter))
                $this->$filter($value);
        }

        /* if($this->request->has('by')){
            $this->by($this->request->by);
        } */

        return $this->builder;
        // if(! $username = $this->request->by) return $builder;
        // return $this->by($username);
    }

    public function getFilters()
    {
        return $this->request->only($this->filters);
    }

   

}