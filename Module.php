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
    /**
     * @var string
     */
    public $controllerNamespace = 'HD\yii\module\Comments\controllers';

    /**
     *  @var string
     */
    const VERSION = '0.0.1';

    /**
     * Конфиг с настройками юзера
     *  @var array
     */

    public $user = [];

    /**
     * Конфиг с настройками reCaptcha.
     * @var array
     */
    public $captcha = [];

    /**
     * Соотношения ключей. Слева ключ, для использование в виджете, справа в таблице юзеров. Написал во имя инкапсуляции
     * @var array
     */
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