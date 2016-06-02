<?php
namespace HD\yii\module\Comments\components;

use yii\base\Component;

class ReCaptcha extends Component{
    /**
     * @var string
     */
    public static $url = 'https://www.google.com/recaptcha/api/siteverify';

    /**
     * @param $request
     * @param $secret
     * @return bool
     */
    public static function validate($request,$secret)
    {
        $url = self::getLink($request,$secret);
        $res = self::getCurlData($url);
        $res = json_decode($res, true);

        return isset($res['success']) && $res['success'];
    }

    /**
     * @param $request
     * @param $secret
     * @return string
     */
    private static function getLink($request,$secret)
    {
        return self::$url.'?secret='.$secret.'&response='.$request.'&remoteip='.$_SERVER['REMOTE_ADDR'];
    }

    /**
     * @param $url
     * @return mixed
     */
    private static function getCurlData($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
        $curlData = curl_exec($curl);
        curl_close($curl);

        return $curlData;
    }

}
?>