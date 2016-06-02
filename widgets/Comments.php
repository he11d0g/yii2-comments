<?php
/**
 * Author: helldog
 * Email: im@helldog.net
 * Url: http://helldog.net
 */
namespace HD\yii\module\Comments\widgets;

use Yii;
use yii\data\ActiveDataProvider;
use HD\yii\module\Comments\models\Comment;

class Comments extends \yii\base\Widget
{
    /**
     * @var integer
     */
    public $pageID;
    /**
     * @var string
     */
    public $isGuest;
    /**
     * @var string
     */
    public $options = [];
    /**
     * @var array
     */
    public $clientOptions = [];

    /**
     * @var bool
     */
    public $renderOnlyComments = false;

    /**
     * @var array Captcha config
     */
    public $captcha;

    public function init()
    {
        parent::init();
        isset($this->options['id'])
            ? $this->setId($this->options['id'])
            : $this->options['id'] = $this->getId();

        if($this->isGuest == null){
            $this->isGuest = Yii::$app->user->isGuest;
        }

        $this->captcha = Yii::$app->getModule('comments')->captcha;

    }

    public function run()
    {
        $view = $this->renderOnlyComments ? 'onlyComments' : 'comments';
        $this->registerJs();
        $dataProvider = new ActiveDataProvider([
            'query' => Comment::find(['page_id' => $this->pageID])->joinWith('user')->orderBy('date'),
            'pagination' => false,
        ]);

        echo $this->render($view, ['comments' => $dataProvider]);
    }

    /**
     * Устнавока конфига для JS
     */
    public function registerJs()
    {
        $this->view->registerJs('
            var hdCommentsConfig = {
                requestUrl : "'.\yii\helpers\Url::toRoute('comments/comment/request').'",
                pageId : "'.$this->pageID.'"
            }
        ', yii\web\View::POS_HEAD);
    }
}