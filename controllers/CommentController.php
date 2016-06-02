<?php
/**
 * Author: helldog
 * Email: im@helldog.net
 * Url: http://helldog.net
 */
namespace HD\yii\module\Comments\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\HttpException;
use HD\yii\module\Comments\models\Comment;
use HD\yii\module\Comments\widgets\Comments;
use HD\yii\module\Comments\components\ReCaptcha;

class CommentController extends \yii\base\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['request'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Все запросы идут через этот экшн. Думаю так будет удобней, и ненужно плодить ссылки в конфиге для JS
     * @throws HttpException
     */
    public function actionRequest()
    {
        $data = '';
        if (Yii::$app->request->getIsPost()) {
            $post = Yii::$app->request->post();
            switch ($post['action']) {
                case 'reload': //обновление списка коментов
                    $data = $this->_reloadComments($post['page_id']);
                    break;
                case 'add'://добавление нового комента
                    $captchaConfig = Yii::$app->getModule('comments')->captcha;
                    //Проверка каптчи
                    if ($captchaConfig){
                        $captchaStatus = !empty($post['captcha']) && $this->_validateCaptcha($post['captcha'], $captchaConfig['secret']);
                    } else {
                        $captchaStatus = true;
                    }
                    $data = $captchaStatus && $this->_addComment($post['body'], $post['page_id'])
                        ? 'Удалено'
                        : 'Ошибка';
                    break;
                case 'delete':
                    $data = $this->_deleteComment($post['id'])
                        ? 'Удалено'
                        : 'Ошибка';
                    break;
                case 'update': //обновление комента
                    $data = $this->_updateComment($post['id'], $post['body'])
                        ? 'Сохранено'
                        : 'Ошибка';
                    break;
            }
        } else {
            throw new HttpException(404, 'Page not found');
        }

        echo $data;
    }

    /**
     * @param $id
     * @param $body
     * @return mixed
     */
    private function _updateComment($id, $body)
    {
        $comment = Comment::findOne(['id' => $id]);
        $comment->body = $body;

        return $comment->update();
    }

    /**
     * @param $id
     * @return mixed
     */
    private function _deleteComment($id)
    {
        return Comment::deleteAll(['id' => $id]);
    }

    /**
     * @param $body
     * @param $page_id
     * @return mixed
     */
    private function _addComment($body, $page_id)
    {
        $comment = new Comment();
        $comment->body = $body;
        $comment->date = time();
        $comment->page_id = $page_id;
        $comment->user_id = Yii::$app->user->id;

        return $comment->save();
    }

    /**
     * @param $page_id
     * @return mixed
     */
    private function _reloadComments($page_id)
    {
        return Comments::widget(['pageID' => $page_id, 'renderOnlyComments' => true]);
    }

    /**
     * @param $response
     * @param $secret
     * @return bool
     */
    private function _validateCaptcha($response, $secret)
    {
        return ReCaptcha::validate($response, $secret);
    }
}