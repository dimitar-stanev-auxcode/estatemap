<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estate;
use App\Http\Controllers\LabelController;

class EstatesController extends Controller
{
    /* JSON-return-type functions
     * below
     */

    public function get_all_estates_json()
    {
        // get all estates from database
        $estates = Estate::all();

        // json-encode data
        $jsonData = json_encode($estates, JSON_UNESCAPED_UNICODE);

        // return the JSON data
        return $jsonData;
    }

    public function get_estates_by_main_parameters_json($deal_type, $estate_type, $room_count, $equipped)
    {
        // convert room count phrase into an integer
        $real_room_count = $this->get_room_count_by_phrase($room_count, $estate_type);

        // get all estates by main properties
        $estates = Estate::where([
            'tip_sdelka' => $deal_type,
            'vid_imot' => $estate_type,
            'stai' => $real_room_count,
            'obzaveden' => $equipped
        ])->get();

        // json-encode data
        $jsonData = json_encode($estates, JSON_UNESCAPED_UNICODE);

        // return the JSON data
        return $jsonData;
    }

    public function get_estates_by_additional_filter_json($deal_type, $estate_type, $room_count, $equipped, $additional_filter)
    {
        // THIS FUNCTION WILL DO THE SAME AS THE ONE ABOVE, EXCEPT THAT IT WILL HANDLE AN ADDITIONAL FILTER
        // ASSOCIATIVE ARRAY VARIABLE AND WILL USE ELOQUENT TO RETRIEVE THE DATA FROM THE DATABASE AND
        // CONVERT IT TO JSON FORMAT, JUST LIKE THE FUNCTION ABOVE

        // convert room count phrase into an integer
        $real_room_count = $this->get_room_count_by_phrase($room_count, $estate_type);
        
        // parse the additional URL parameters into an associative array
        parse_str($additional_filter, $all_filters)

        // use laravel helper functions to add the 4 main parameters into the all_filters array
        array_add($all_filters, 'tip_sdelka', $deal_type);
        array_add($all_filters, 'vid_imot', $estate_type);
        array_add($all_filters, 'stai', $real_room_count);
        array_add($all_filters, 'obzaveden', $equipped);

        // return the array
        print_r($all_filters);
    }

    /* View-return-type functions
     * below
     */

    public function get_all_estates()
    {
        // get the json data
        $jsonData = $this->get_all_estates_json();

        // return the JSON data to the home-map view and render the map
        return view('home', ['estatesJson' => $jsonData]);
    }

    public function get_estates_by_main_parameters($deal_type, $estate_type, $room_count, $equipped)
    {
        // get the json data
        $jsonData = get_estates_by_main_parameters_json($deal_type, $estate_type, $room_count, $equipped);

        // return the JSON data to the home-map view and render the map
        return view('home', ['estatesJson' => $jsonData]);
    }

    public function get_estates_by_additional_filter($deal_type, $estate_type, $room_count, $equipped, $additional_filter)
    {
        // THIS FUNCTION WILL DO THE SAME AS THE ONE ABOVE, EXCEPT THAT IT WILL HANDLE AN ADDITIONAL FILTER
        // ASSOCIATIVE ARRAY VARIABLE AND WILL USE ELOQUENT TO RETRIEVE THE DATA FROM THE DATABASE AND
        // CONVERT IT TO JSON FORMAT, JUST LIKE THE FUNCTION ABOVE
    }

    public function view_single_estate(Request $request, $id)
    {
        // THIS FUNCTION WILL REPLACE viewEstate FUNCTION BELOW

        // get estate object
        $estate = Estate::where('id', $id)->first();

        // create labels
        $estate_labels = array(
            'room_count' => $this->get_estate_room_count_label($estate->stai),
            'furnishing' => $this->get_estate_furnishing_label($estate->obzaveden),
            'region' => $this->get_estate_region_label($estate->kvartal, $estate->raion)
        );

        return view('estate.view_estate', ['estate' => $estate, 'estate_labels' => $estate_labels, 'title' => $this->createEstateTitle($estate)]);
    }

    public function viewEstate(Request $request, $estate_name)
    {
        // get estate object
        $estate = Estate::where('estate_name', $estate_name)->first();

        // create labels
        $estate_labels = array(
            'room_count' => $this->get_estate_room_count_label($estate->stai),
            'furnishing' => $this->get_estate_furnishing_label($estate->obzaveden),
            'region' => $this->get_estate_region_label($estate->kvartal, $estate->raion)
        );

        return view('estate.view_estate', ['estate' => $estate, 'estate_labels' => $estate_labels, 'title' => $this->createEstateTitle($estate)]);
    }

    public function insertEstatePhotos(Request $request)
    {
        /* code, copied from naem.net
        $target_path = public_path() . '/images/estates/';
        $files_count = count($_FILES);

        if ($files_count > 0) {
            foreach ($_FILES as $cur_index=>$cur_file) {
                $cur_target_path = $target_path . basename($cur_file['name']);

                //$tmp_name = $cur_file['tmp_name'];
                //$tmp_target_path = $cur_target_path;

                if (move_uploaded_file($cur_file['tmp_name'], $cur_target_path)) {
                    $log .= date("Y-m-d H:i:s") . ": " . basename($cur_file['name']). " has been uploaded\r\n";
                } else {
                    $log .= date("Y-m-d H:i:s") . ": " . basename($cur_file['name']). " failed to be uploaded\r\n";
                }
            }
        }
        */

        // laravel code

        // define target path for uploads
        $target_path = public_path() . '/images/estates/';

        // create array to store photos
        $photos = array();

        // check for image 1
        if($request->hasFile('photo1') and $request->file('photo1')->isValid())
        {
            // move the uploaded file
            $request->file('photo1')->storeAs($target_path, 'estate_10_1.' . $request->file('photo1')->extension());
        }
        else {
            abort(500, 'Unsuccessful upload.');
        }
    }

    public function insertEstate(Request $request)
    {
        // create estate object from model
        $estate = new Estate;

        // check if request is coming from MS Access
        $fromAccess = true;
        if($request->has('fromAccess') and !$request->input('fromAccess')) {
            $fromAccess = false;
        }

        // get all request parameters
        if ($request->has('SELO')) $estate->selo = mb_convert_encoding($request->input('SELO'), 'utf-8', 'windows-1251');

        if ($request->has('VID')) $estate->vid_imot = mb_convert_encoding($request->input('VID'), 'utf-8', 'windows-1251');

        if ($request->has('SDELKA')) $estate->tip_sdelka = mb_convert_encoding($request->input('SDELKA'), 'utf-8', 'windows-1251');

        if ($request->has('ORIENTIR')) $estate->orientir = mb_convert_encoding($request->input('ORIENTIR'), 'utf-8', 'windows-1251');

        if ($request->has('ETAZ')) $estate->etaj = mb_convert_encoding($request->input('ETAZ'), 'utf-8', 'windows-1251');

        if ($request->has('ETAZPODROBNO')) $estate->etaj_podrobno = mb_convert_encoding($request->input('ETAZPODROBNO'), 'utf-8', 'windows-1251');

        if ($request->has('KVARTAL')) $estate->kvartal = mb_convert_encoding($request->input('KVARTAL'), 'utf-8', 'windows-1251');

        if ($request->has('RAJON')) $estate->raion = mb_convert_encoding($request->input('RAJON'), 'utf-8', 'windows-1251');

        if ($request->has('CITY')) $estate->grad = mb_convert_encoding($request->input('CITY'), 'utf-8', 'windows-1251');

        if ($request->has('OBZ')) $estate->obzaveden = mb_convert_encoding($request->input('OBZ'), 'utf-8', 'windows-1251');

        if ($request->has('OBZAVEZDANE')) $estate->obzavejdane = mb_convert_encoding($request->input('OBZAVEZDANE'), 'utf-8', 'windows-1251');

        if ($request->has('STAI')) $estate->stai = mb_convert_encoding($request->input('STAI'), 'utf-8', 'windows-1251');

        if($request->has('PR/NPR')) $estate->pr_npr = mb_convert_encoding($request->input('PR/NPR'), 'utf-8', 'windows-1251');

        if ($request->has('M2')) $estate->plosht = mb_convert_encoding($request->input('M2'), 'utf-8', 'windows-1251');

        if ($request->has('DRUGI')) $estate->drugi = mb_convert_encoding($request->input('DRUGI'), 'utf-8', 'windows-1251');

        if ($request->has('NAEM')) $estate->naem = mb_convert_encoding($request->input('NAEM'), 'utf-8', 'windows-1251');

        if ($request->has('SASTIOBZ')) $estate->sustoqnie = mb_convert_encoding($request->input('SASTIOBZ'), 'utf-8', 'windows-1251');

        if ($request->has('VID_STROITELSTVO')) $estate->vid_stroitelstvo = mb_convert_encoding($request->input('VID_STROITELSTVO'), 'utf-8', 'windows-1251');

        if ($request->has('N')) $estate->kartoteka_n = mb_convert_encoding($request->input('N'), 'utf-8', 'windows-1251');

        if ($request->has('TEC')) $estate->tec = mb_convert_encoding($request->input('TEC'), 'utf-8', 'windows-1251');

        if ($request->has('TEL')) $estate->tel = mb_convert_encoding($request->input('TEL'), 'utf-8', 'windows-1251');

        if ($request->has('BROKER')) $estate->za_ogled_tursete = mb_convert_encoding($request->input('BROKER'), 'utf-8', 'windows-1251');

        if ($request->has('TELEFON_BROKER')) $estate->za_ogled_telefon = mb_convert_encoding($request->input('TELEFON_BROKER'), 'utf-8', 'windows-1251');

        if ($request->has('SNIMKA1')) $snimka1 = mb_convert_encoding($request->input('SNIMKA1'), 'utf-8', 'windows-1251');

        if ($request->has('SNIMKA2')) $snimka2 = mb_convert_encoding($request->input('SNIMKA2'), 'utf-8', 'windows-1251');

        if ($request->has('SNIMKA3')) $snimka3 = mb_convert_encoding($request->input('SNIMKA3'), 'utf-8', 'windows-1251');

        if ($request->has('SNIMKA4')) $snimka4 = mb_convert_encoding($request->input('SNIMKA4'), 'utf-8', 'windows-1251');

        if ($request->has('SNIMKA5')) $snimka5 = mb_convert_encoding($request->input('SNIMKA5'), 'utf-8', 'windows-1251');

        // generate slug
        $estate->estate_name = $this->make_slug($this->createEstateTitle($estate));

        // define photos array
        $photosArray = array();

        for($currentPhoto = 0; $currentPhoto < 5; $currentPhoto++)
        {
            // define photo path
            $photoPath = "";

            switch($currentPhoto)
            {
                case 0:
                    if(isset($snimka1)) $photoPath = $snimka1;
                    break;
                case 1:
                    if(isset($snimka2)) $photoPath = $snimka2;
                    break;
                case 2:
                    if(isset($snimka3)) $photoPath = $snimka3;
                    break;
                case 3:
                    if(isset($snimka4)) $photoPath = $snimka4;
                    break;
                case 4:
                    if(isset($snimka5)) $photoPath = $snimka5;
                    break;
                default:
                    $photoPath = "";
            }

            if($photoPath != "") {
                // add photo to array
                $photosArray[] = $photoPath;
            }
        }

        // from photos array, create a photo list string
        if(!empty($photosArray))
        {
            // form photos list
            $photosList = implode(';', $photosArray);

            // add estate photos
            $estate->snimki = $photosList;
        }

        // insert estate into the database
        $estate->save();
    }

    public function removeEstate(Request $request)
    {
        if($request->has('N')) {
            Estate::where('kartoteka_n', $request->input('N'))->delete();
        }
        else {
            abort(500, 'Missing parameters! Check deleteEstate() function in EstatesController.');
        }
    }

    // HELPER FUNCTIONS BELOW, TO BE TRANSFERRED ELSEWHERE

    function get_room_count_by_phrase($room_count_phrase, $estate_type)
    {
        // define whether the estate is a business property
        $business_property = true;

        // define all non-business property types
        $non_business_properties = ['апартамент', 'къща-за-жилище', 'етаж от къща', 'вила', 'стая', 'хотел'];

        // check if estate is a business property type
        if(in_array($estate_type, $non_business_properties))
        {
            // not a business property
            $business_property = false;

            // get room count as an integer
            switch($room_count_phrase)
            {
                case 'едностаен':
                    return 1;
                    break;
                case 'двустаен':
                    return 2;
                    break;
                case 'тристаен':
                    return 3;
                    break;
                case 'четиристаен':
                    return 4;
                    break;
                case '5-стаен':
                    return 5;
                    break;
                case '6-стаен':
                    return 5;
                    break;
                case '7-стаен':
                    return 5;
                    break;
                case '8-стаен':
                    return 5;
                    break;
                case '9-стаен':
                    return 5;
                    break;
                case '10-стаен':
                    return 5;
                    break;
                default:
                    return 0;
            }
        }
        else
        {
            // get room count for business properties
            return explode('-', $room_count_phrase)[1];
        }
    }

    function makeSlug($string = null, $separator = "-")
    {
        if (is_null($string)) {
            return "";
        }

        // remove spaces from the beginning and from the end of the string
        $string = trim($string);

        // lower case everything
        $string = mb_strtolower($string, "UTF-8");;

        // make alphanumeric (removes all other characters)
        $string = preg_replace("/[^a-z0-9_\s-аАбБвВгГдДеЕжЖзЗиИйЙкКлЛмМнНоОпПрРсСтТуУфФхХцЦчЧшШщЩъЪьюЮяЯ]/u", "", $string);

        // remove multiple dashes or whitespaces
        $string = preg_replace("/[\s-]+/", " ", $string);

        // convert whitespaces and underscore to the given separator
        $string = preg_replace("/[\s_]/", $separator, $string);

        // return the slug
        return $string;
    }

    // create title from estate data
    public function createEstateTitle($estate)
    {
        // define title string
        $titleString = '';

        // sale or rent
        if($estate->tip_sdelka == 'наем') {
            $titleString .= 'Дава под наем ';
        }
        if($estate->tip_sdelka == 'продажба') {
            $titleString .= 'Продава ';
        }

        // add estate type
        $titleString .= $estate->vid_imot . ' в ';

        // add city and region
        $titleString .= $estate->grad . ', ' . $estate->kvartal;

        // return title
        return $titleString;
    }

    public function get_estate_region_label($kvartal, $raion)
    {
        if(!empty($kvartal)) {
            return $kvartal;
        }

        if(!empty($raion) and empty($kvartal)) {
            return $raion;
        }

        if(empty($kvartal) and empty($raion)) {
            return 'Няма информация';
        }
    }

    /***********************************************
     * 
     ***********************************************
     *
     */
    public function get_estate_room_count_label($room_count)
    {
        switch($room_count)
        {
            case 0:
                return 'Многостаен';
                break;
            case 1:
                return 'Едностаен';
                break;
            case 2:
                return 'Двустаен';
                break;
            case 3:
                return 'Тристаен';
                break;
            case 4:
                return 'Четиристаен';
                break;
            default:
                return 'Няма информация';
        }
    }

    public function get_estate_furnishing_label($furnishing)
    {
        switch($furnishing)
        {
            case 'ДА':
                return 'Обзаведен';
                break;
            case 'НЕ':
                return 'Необзаведен';
                break;
            default:
                return 'Няма информация';
        }
    }
}