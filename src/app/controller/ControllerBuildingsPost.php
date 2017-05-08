<?php
/**
 * Created by PhpStorm.
 * User: bertr
 * Date: 06/03/2017
 * Time: 10:12
 */

namespace app\controller;

use app\model\Building;
use app\model\Comment;
use app\model\Image;

class ControllerBuildingsPost {

    private $params;

    public function __construct($p) {
        $this->params = $p;
    }

    public function postBuilding() {

        $opts = array(
            'http' => array(
                'method' => "GET"
            )
        );

        $context = stream_context_create($opts);
        $url = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?location='. $this->params['latitude'] .','.
            $this->params['longitude'].'&radius=100&name='. $this->params['name'] .'&key=YOUR_API_KEY_HERE';
        $url = preg_replace("/ /", "%20", $url);
        $file = file_get_contents($url);
        $json = json_decode($file, true)["results"];

        $json2 = array();
        $comments = array();

        if(count($json) > 0) {
            $url = 'https://maps.googleapis.com/maps/api/place/details/json?placeid=' . $json[0]["place_id"] . '&key=YOUR_API_KEY_HERE';
            $url = preg_replace("/ /", "%20", $url);
            $file = file_get_contents($url);
            $json2 = json_decode($file, true)["result"];
        }

        $b = new Building();
        $b->name = $this->params['name'];
        $b->latitude = $this->params['latitude'];
        $b->longitude = $this->params['longitude'];
        $b->street = $this->params['street'];
        $b->postalCode = $this->params['postalCode'];
        $b->city = $this->params['city'];
        $b->country = $this->params['country'];
        $b->description = $this->params['description'];

        if(count($json) > 0) {
            $b->placeID = $json[0]["place_id"];
        } else {
            $b->placeID = " ";
        }

        if(count($json2) > 0) {

            if(isset($json2["international_phone_number"])) {
                $b->phone = $json2["international_phone_number"];
            } else {
                $b->phone = "";
            }

            if(isset($json2["website"])) {
                $b->website = $json2["website"];
            } else {
                $b->website = "";
            }

            if(isset($json2["rating"])) {
                $b->rating = $json2["rating"];
            } else {
                $b->rating = "-";
            }

        } else {
            $b->phone = "";
            $b->website = "";
            $b->rating = "-";
        }

        $b->save();

        if(count($json2) > 0) {
            $this->saveComments($json2, $b->id);
            $this->saveImages($json2, $b->id);
        }

    }


    /**
     * Method used to save images url for a place
     */
    private function saveImages($json2, $id) {


        if(isset($json2["photos"])) {
            for($i = 0; $i < 3; $i++) {
                if(isset($json2["photos"][$i])) {
                    $photoReference = $json2["photos"][$i]["photo_reference"];
                    $img = new Image();
                    $img->idBuilding = $id;
                    $img->reference = $photoReference;
                    $img->save();
                }
            }
        }

    }


    /**
     * Method used to save the comments for a place
     */
    private function saveComments($json2, $id) {

        if(isset($json2["reviews"])) {

            $comments = $json2["reviews"];

            for($i = 0; $i < 3; $i++) {

                if(isset($comments[$i])) {
                    $c = new Comment();
                    if(isset($comments[$i]["rating"])) { $c->rating = $comments[$i]["rating"]; } else { $c->rating = "-"; }
                    if(isset($comments[$i]["author_name"])) { $c->author = $comments[$i]["author_name"]; } else { $c->author = "Unknown Author"; }
                    //if(isset($comments[$i]["date"])) { $c->date = date("d/m/Y", $comments[$i]["date"]/1000); }
                    if(isset($comments[$i]["text"])) { $c->text = $comments[$i]["text"]; } else { $c->text = ""; }
                    $c->idBuilding = $id;
                    $c->save();
                }

            }

        }

    }

}