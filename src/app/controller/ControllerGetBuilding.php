<?php
/**
 * Created by PhpStorm.
 * User: bertr
 * Date: 13/03/2017
 * Time: 12:47
 */

namespace app\controller;


use app\model\Building;
use app\model\Comment;
use app\model\Image;

class ControllerGetBuilding {

    private $params;

    public function __construct($p) {
        $this->params = $p;
    }

    public function getBuilding() {

        $building = Building::all()
            ->where('latitude', '=', $this->params['latitude'])
            ->where('longitude', '=', $this->params['longitude'])
            ->first()
            ->toArray();

        // Comments
        $comments = Comment::all()
            ->where('idBuilding', '=', $building["id"])
            ->toArray();

        $commentsArray = array();

        foreach($comments as $c) {
            $commentsArray["comments"][] = $c;
        }

        // Images
        $images = Image::all()
            ->where('idBuilding', '=', $building["id"])
            ->toArray();

        $imagesArray = array();

        foreach($images as $img) {
            $imagesArray["images"][] = array(
                "reference" => $img["reference"]
            );
        }

        // Final result
        $finalArray = array_merge($building, $commentsArray, $imagesArray);
        header("Content-Type: application/json");
        echo json_encode($finalArray);

    }

}