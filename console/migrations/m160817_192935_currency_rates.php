<?php

use yii\db\Migration;

class m160817_192935_currency_rates extends Migration
{
    public function up()
    {
		$tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%currency_rates}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string('3')->notNull(),
			'rate' => $this->float(),
        ], $tableOptions);
		
		$this->createIndex('uniq_code', '{{%currency_rates}}', 'code', true);
		$this->createIndex('uniq_code', '{{%currency}}', 'code', true);
    }

    public function down()
    {
		$this->dropTable('{{%currency_rates}}');
		$this->dropIndex('uniq_code', '{{%currency}}', 'code', true);
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
