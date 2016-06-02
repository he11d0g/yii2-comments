<?php

namespace HD\yii\module\Comments\models;

use Yii;

/**
 * This is the model class for table "hd_comment".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $date
 * @property string  $body
 */
class Comment extends \yii\db\ActiveRecord
{

    /**
     * Параметры юзера из модуля
     * @var array
     */
    private $_userParams;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hd_comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id','page_id','body'], 'required'],
            [['id','user_id','page_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User id',
            'date' => 'Date',
            'page_id' => 'Page id',
            'body' => 'Body',
        ];
    }

    public function init()
    {
        $this->_userParams = Yii::$app->getModule('comments')->user;
    }

    /**
     * Связь коментов с юзером
     * @return $this
     */
    public function getUser()
    {
        if(isset($this->_userParams['class'])){
            $userClass = $this->_userParams['class'];
            $pk = $userClass::primaryKey();
            return $this->hasOne($userClass::className(), [$pk[0] => 'user_id']);
        }

        return $this;
    }

    /**
     * Получаения ключа для таблицы с Юзерами
     * @param $param
     * @return bool
     */
    public function getUserAttr($param)
    {
        return isset($this->_userParams['keyMap'][$param],$this->user)
            ? $this->user[$this->_userParams['keyMap'][$param]]
            : false;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            //Пропускаем только <a>
            $this->body = strip_tags($this->body,'<a></a>');

            return true;
        }
        return false;
    }

}
