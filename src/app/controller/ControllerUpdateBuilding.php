<?php
/**
 * Created by PhpStorm.
 * User: bertr
 * Date: 13/03/2017
 * Time: 18:10
 */

namespace app\controller;


use app\model\Building;

class ControllerUpdateBuilding {

    private $params;

    public function __construct($p) {
        $this->params = $p;
    }

    public function updateBuilding() {

        $building = Building::all()
            ->where('latitude', '=', $this->params['latitude'])
            ->where('longitude', '=', $this->params['longitude'])
            ->first();

        $building->description = $this->params['description'];
        $building->save();

    }

}