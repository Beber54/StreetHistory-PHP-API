<?php
/**
 * Created by PhpStorm.
 * User: bertr
 * Date: 12/03/2017
 * Time: 12:34
 */

namespace app\controller;

use app\model\Building;

class ControllerBuildingsGetRegion {

    private $params;

    public function __construct($p) {
        $this->params = $p;
    }

    public function getBuildingsRegion() {

        $buildingsArray = array();

        $buildingsLat = Building::all()
            ->where('latitude', '<', $this->params['northEastLatitude'])
            ->where('latitude', '>', $this->params['southWestLatitude'])
            ->where('longitude', '<', $this->params['northEastLongitude'])
            ->where('longitude', '>', $this->params['southWestLongitude']);

        foreach($buildingsLat as $b) {
            $buildingsArray["countries"][$b->country][] = array(
                "name" => $b->name,
                "latitude" => $b->latitude,
                "longitude" => $b->longitude,
                "street" => $b->street,
                "postalCode" => $b->postalCode,
                "city" => $b->city,
                "description" => $b->description
            );
        }

        header("Content-Type: application/json");
        echo json_encode($buildingsArray);

    }

}