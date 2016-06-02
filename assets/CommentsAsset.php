<?php
/**
 * Author: helldog
 * Email: im@helldog.net
 * Url: http://helldog.net
 */
namespace HD\yii\module\Comments\assets;

use Yii;
use yii\web\AssetBundle;

class CommentsAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@vendor/he11d0g/yii2-comments/assets/';
    /**
     * @var array
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'HD\yii\module\Comments\assets\SemanticUIAsset'
    ];
    public function init()
    {
        $this->js[] = 'js/main.js';
        $this->css[] = 'css/main.css';
        parent::init();
    }
}