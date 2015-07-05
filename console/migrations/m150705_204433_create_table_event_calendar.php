<?php

use yii\db\Schema;
use yii\db\Migration;

class m150705_204433_create_table_event_time extends Migration
{
	const TABLE = 'event_time';
    public function up()
    {
			$this->createTable('{{%'.self::TABLE.'}}', [
				'id' => Schema::TYPE_PK,
				'event_id' => Schema::TYPE_INTEGER . ' NOT NULL',
				'day' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 10',
				'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 10',
				'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
				'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
			],  'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
    }

    public function down()
    {
    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
