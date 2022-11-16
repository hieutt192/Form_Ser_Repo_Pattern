<?php

namespace App\Libraries;

class Common
{
    /**
     * @param $string
     * @return string
     */
    public static function clearXSS($string): string
    {
        $string = nl2br($string);
        $string = trim(strip_tags($string));
        return self::removeScripts($string);
    }

    /**
     * @param $str
     * @return string
     */
    public static function removeScripts($str): string
    {
        $regex =
            '/(<link[^>]+rel="[^"]*stylesheet"[^>]*>)|' .
            '<script[^>]*>.*?<\/script>|' .
            '<style[^>]*>.*?<\/style>|' .
            '<!--.*?-->/is';

        return preg_replace($regex, '', $str);
    }

    /**
     * @param $array
     * @return array
     */
    public static function clearArray($array): array
    {
        $data = [];
        foreach ($array as $key => $value) {
            if(is_array($value)) {
                $data[$key] = self::clearArray($value);
            } else {
                $data[$key] = self::clearXSS($value);
            }
        }

        return $data;
    }
}
