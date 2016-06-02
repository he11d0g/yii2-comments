<?php

use yii\db\Migration;

/**
 * Handles the creation for table `hd_user`.
 */
class m160602_195812_create_hd_user extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('hd_user', [
            'id' => $this->primaryKey(),
            'email' => $this->string(50)->notNull()->unique(),
            'name' => $this->string(50)->notNull(),
        ]);
        $this->createIndex('name','hd_user','name');

        $this->insert('hd_user', [
            'id' => 1,
            'email' => 'alesh@site.ru',
            'name' => 'Алеша Попович',
        ]);

        $this->insert('hd_user', [
            'id' => 2,
            'email' => 'zmei@bbc.ru',
            'name' => 'Тугарин Змеевич',
        ]);

        $this->insert('hd_user', [
            'id' => 3,
            'email' => 'klinklin@gmail.com',
            'name' => 'Клинтон Биллович',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('hd_user');
    }
}
