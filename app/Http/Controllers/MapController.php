<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estate;

class MapController extends Controller
{
    public function allEstates()
    {
        // get all estates
        $estates = Estate::all();

        // json-encode and return
        return json_encode($estates, JSON_UNESCAPED_UNICODE);
    }

    public function has_next($array)
    {
        if(is_array($array))
        {
            if(next($array) === false) {
                return false;
            }
            else {
                return true;
            }
        }
        else {
            return false;
        }
    }

    public function getFilteredEstates($filter)
    {
        // convert URL input into an array
    	parse_str($filter, $filter_arr);
    	$query = '';
        $i = true;
    	while($i)
        {
		    if($this->has_next($filter_arr)) {
		    	$query = $query .' '. key($filter_arr) . '=' . current($filter_arr) . ' OR ';
		    }
		    else {
                $query = $query .' '. key($filter_arr) . '=' . current($filter_arr);
                $i=false;
            }
		}

        // use the custom-built query to retrieve all estates with these parameters
    	$estates = Estate::whereRaw($query)->get();

        // finally, return the JSON data to the home-map view and render the map
        return view('home', ['estatesJson' => json_encode($estates,JSON_UNESCAPED_UNICODE), 'estates'=>$estates ,'query'=>$query]);
    }
}