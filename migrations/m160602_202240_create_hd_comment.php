<?php

use yii\db\Migration;

/**
 * Handles the creation for table `hd_comment`.
 */
class m160602_202240_create_hd_comment extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('hd_comment', [
            'id' => $this->primaryKey(11),
            'user_id' => $this->integer(11)->notNull(),
            'page_id' => $this->integer(11)->notNull(),
            'date' => $this->integer(11)->notNull(),
            'body' => $this->text()->notNull(),
        ]);

        $this->createIndex('hd_user_id','hd_comment','user_id');
        $this->createIndex('hd_page_id','hd_comment','page_id');
        $this->createIndex('hd_date','hd_comment','date');

        $this->insert('hd_comment', [
            'id' => 1,
            'user_id' => 1,
            'page_id' => 1,
            'date' => 1464874794,
            'body' => 'Мой коммент номер 1',
        ]);

        $this->insert('hd_comment', [
            'id' => 17,
            'user_id' => 3,
            'page_id' => 1,
            'date' => 1464878794,
            'body' => 'Кто здесь ?',
        ]);

        $this->insert('hd_comment', [
            'id' => 31,
            'user_id' => 2,
            'page_id' => 1,
            'date' => 1464894571,
            'body' => '<a href="http://yii-comments.helldog.net/index.php" target="_blank">http://yii-comments.helldog.net/index.php</a>',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('hd_comment');
    }
}
