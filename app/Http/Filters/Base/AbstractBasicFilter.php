<?php


namespace App\Http\Filters\Base;


class AbstractBasicFilter
{
    protected $builder;

    public function __construct($builder)
    {
        $this->builder = $builder;
    }

    public function filter($value){
        return $this->builder;
    }


}
