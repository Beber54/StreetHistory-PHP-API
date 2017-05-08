<?php

/**
 * Created by PhpStorm.
 * User: bertr
 * Date: 06/03/2017
 * Time: 10:46
 */

namespace app\model;

use Illuminate\Database\Eloquent\Model;

class Image extends Model {

    protected $table = 'image';
    protected $primaryKey = 'id';
    public $timestamps = false;

}