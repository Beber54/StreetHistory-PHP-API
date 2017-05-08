<?php
/**
 * Created by PhpStorm.
 * User: bertr
 * Date: 12/03/2017
 * Time: 12:34
 */

namespace app\controller;

use app\model\Building;

class ControllerGetGeoJson {

    public function getGEOJSON() {

        $buildingsArray = array();
        $buildings = Building::all();
        $buildingsGeoJson = array();

        $buildingsGeoJson["type"] = "FeatureCollection";

        foreach($buildings as $b) {

            $buildingsGeoJson["features"][] = array(

                "type" => "Feature",
                "geometry" => array(
                    "type" => "Point",
                    "coordinates" => array($b->longitude, $b->latitude)
                ),

                "properties" => array(
                    "name" => $b->name,
                    //"description" => $b->description,
                    "street" => $b->street,
                    //"postalCode" => $b->postalCode,
                    //"city" => $b->city,
                    //"country" => $b->country,
                )

            );

        }

        header("Content-Type: application/json");
        echo json_encode($buildingsGeoJson);

    }

}