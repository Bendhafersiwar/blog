<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //use this table when working with this model
    protected $table='categories';

    public function posts(){
        return $this->hasMany('App\Post');
    }
}
