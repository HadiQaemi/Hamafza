<?php
namespace App\Http\Controllers\Hamahang;

use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class CaptchaController extends Controller
{
    public function Index($section)
    {
        if (!in_array($section, config('captcha.available_sections')))
        {
            abort(403);
        }
        $length = config('captcha.length');
        $color = config('captcha.color');
        $quality = config('captcha.quality');
        $width = config('captcha.width');
        $height = config('captcha.height');
        $random_string = str_replace('O', '5', strtoupper(md5(rand(0, 1000000))));
        $random_string = str_replace('0', 'H', $random_string);
        $random_string = str_replace('B', 'F', $random_string);
        $random_string = str_replace('8', '9', $random_string);
        $captcha = substr($random_string, rand(0, 3), $length);
        session()->put('captcha_' . $section, $captcha);
        $im = imagecreatetruecolor($width, $height);//200 x 70 pixel image
        $black = imagecolorallocate($im, 0, 0, 0);
        imagecolortransparent($im, $black);//give it a black background
        switch (rand(0, 4))
        {
            case 0:
                $color = imagecolorallocate($im, 34, 155, 91);
                break;
            case 1:
                $color = imagecolorallocate($im, 233, 26, 74);
                break;
            case 2:
                $color = imagecolorallocate($im, 233, 26, 195);
                break;
            case 3:
                $color = imagecolorallocate($im, 244, 178, 19);
                break;
            case 4:
                $color = imagecolorallocate($im, 53, 125, 199);
                break;
        }
        //pick a random color for the text
        $x = 20;
        $y = 47;//the starting position for drawing
        for ($i = 0; $i < $length; $i++)
        {
            $angle = rand(-8, 8) + rand(0, 9) / 10;
            $fontsize = rand(22, 32);//pick a random font size
            $letter = substr($captcha, $i, 1);
            imagealphablending($im, true);
            $coords = imagettftext($im, $fontsize, $angle, $x, $y, $color, config('captcha.CAPTCHA_FONT_ADDRESS'), $letter);
            //draw each letter
            $x += ($coords[2] - $x) + 1;
        }
//        imagecolorallocate($im, 255, 255, 255);
        $img = Image::make($im);
//        $img->colorize(30, 30, 30);
        return $img->response('jpg', $quality);
    }
}
