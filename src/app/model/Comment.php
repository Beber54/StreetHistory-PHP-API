<?php
/**
 * Created by PhpStorm.
 * User: bertr
 * Date: 15/03/2017
 * Time: 16:33
 */

namespace app\model;


use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

    protected $table = 'comment';
    protected $primaryKey = 'id';
    public $timestamps = false;

}