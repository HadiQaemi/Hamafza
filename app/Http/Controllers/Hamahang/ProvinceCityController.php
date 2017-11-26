<?php
namespace App\Http\Controllers\Hamahang;

use DB;
use Auth;
use Request;
use Redirect;
use Storage;
use App\Models\Hamahang\ProvinceCity\Province;
use App\Models\Hamahang\ProvinceCity\City;
use App\Http\Controllers\Controller;

class ProvinceCityController extends Controller
{
    function Import()
    {
        $contents = Storage::disk('public')->get('city_province_log_lat.php');
        $dom = new \DOMDocument();
        $dom->encoding = 'UTF-8';
        @$dom->loadHTML('<?xml encoding="UTF-8">' .$contents);
        $dom->encoding = 'UTF-8';
        foreach ($dom->getElementsByTagName('optgroup') as $province)
        {
            $province_cites = $dom->saveHTML($province);
            $Province = new Province;
            $Province->uid = Auth::id() ;
            $Province->name = $province->getAttribute('label');
            $Province->save();
            $dom2 = new \DOMDocument();

            @$dom2->loadHTML('<?xml encoding="UTF-8">' .$province_cites);
            foreach ($dom2->getElementsByTagName('option') as $value)
            {
                $City = new City;
                $City->uid          = Auth::id();
                $City->province_id  = $Province->id;
                $City->name         = $value->textContent;
                $City->lng          = $value->getAttribute('lng');
                $City->lat          = $value->getAttribute('lat');
                $City->save();
            }
        }

    }
    public function getProvince()
    {
        return Province::all()->toJson();
    }
    public function getCity($id)
    {
        return City::select('id','name')
                    ->where('province_id','=',$id)
                    ->get()
                    ->toJson();
    }
}