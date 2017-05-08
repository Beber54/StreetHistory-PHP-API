<?php

/**
 * Created by PhpStorm.
 * User: bertr
 * Date: 06/03/2017
 * Time: 10:46
 */

namespace app\model;

use Illuminate\Database\Eloquent\Model;

class Building extends Model {

    protected $table = 'building';
    protected $primaryKey = 'id';
    public $timestamps = false;

}