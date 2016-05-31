<?php
/**
 * Author: helldog
 * Email: im@helldog.net
 * Url: http://helldog.net
 */
namespace HD\yii\module\Comments\assets;

use Yii;
use yii\web\AssetBundle;

class CommentsJSAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@vendor/bower/semantic/dist';
    /**
     * @var array
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'HD\yii\module\Comments\assets\CommentsCSSAsset'
    ];
    public function init()
    {
        $this->js[] = 'semantic.min.js';
        parent::init();
    }
}