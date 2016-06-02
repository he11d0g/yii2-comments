<?php
/**
 * Author: helldog
 * Email: im@helldog.net
 * Url: http://helldog.net
 */
namespace HD\yii\module\Comments;

use HD\yii\module\Comments\assets\CommentsJSAsset;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'HD\yii\module\Comments\controllers';

    const VERSION = '0.0.1';

    public $user = [];

    public $captcha = [];

    private $_defaultMap = [
        'email' => 'email',
        'date' => 'date',
        'name' => 'name',
        'body' => 'body',
    ];

    public function init()
    {
        parent::init();
        if($this->user !== false){
            if(!isset($this->user['keyMap'])){
                $this->user['keyMap'] = $this->_defaultMap;
            } else {
                $this->user['keyMap'] = array_merge($this->_defaultMap,$this->user['keyMap']);
            }
            if(!isset($this->user['class'])){
                $this->user['class'] = 'yii\models\User';
            }

        }

        if($this->user !== false){
            if(!isset($this->captcha['siteKey'])){
                $this->captcha['siteKey'] = '';
            }

            if(!isset($this->captcha['secret'])){
                $this->captcha['secret'] = '';
            }

        }
    }
}