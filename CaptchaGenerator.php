<?php

use Mews\Captcha\Facades\Captcha;

class CaptchaGenerator
{

    const FOLDER = 'images_train/';
    const COUNT = 2000;

    public function run()
    {
        for ($i = 0; $i < self::COUNT; $i++) {
            $this->geneCaptcha();
            if ($i % 100 == 0) {
                print "$i code done";
            }
        }
    }


    private function geneCaptcha()
    {
        list($res, $text) = Captcha::create();

        $image = imagecreatefromstring($res->getContent());

        $colors = $this->imageToArray($image);

        $char1 = $this->cut($colors, 0, 30);
        $char2 = $this->cut($colors, 30, 60);
        $char3 = $this->cut($colors, 60, 90);
        $char4 = $this->cut($colors, 90, 120);

        $this->saveImg($char1, $text[0]);
        $this->saveImg($char2, $text[1]);
        $this->saveImg($char3, $text[2]);
        $this->saveImg($char4, $text[3]);
    }

    private function saveImg($pixelArray, $name)
    {
        $width = count($pixelArray[0]);
        $height = count($pixelArray);

        $img = imagecreatetruecolor($width, $height);

        for ($y = 0; $y < $height; ++$y) {
            for ($x = 0; $x < $width; ++$x) {
                list($r, $g, $b) = $pixelArray[$y][$x];
                $color = imagecolorallocate($img, $r, $g, $b);
                imagesetpixel($img, $x, $y, $color);
            }
        }

        if (!file_exists(self::FOLDER . $name)) {
            mkdir(self::FOLDER . $name, 0777, true);
        }

        imagepng($img, self::FOLDER . $name . '/' . str_random(32) . '.png');
    }


    private function imageToArray($image)
    {
        $width = imagesx($image);
        $height = imagesy($image);
        $colors = [];

        for ($y = 0; $y < $height; $y++) {
            $y_array = [];

            for ($x = 0; $x < $width; $x++) {
                $rgb = imagecolorat($image, $x, $y);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;

                $x_array = [$r, $g, $b];
                $y_array[] = $x_array;
            }
            $colors[] = $y_array;
        }

        return $colors;
    }

    private function cut(array $colors, $start, $stop)
    {
        $middle = [];
        for ($i = $start; $i < $stop; $i++) {
            $middle[] = array_column($colors, $i);
        }

        $output = [];
        for ($i = 0; $i < count($middle[0]); $i++) {
            $output[] = array_column($middle, $i);
        }

        return $output;
    }

}
