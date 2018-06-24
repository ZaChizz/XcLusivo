<?php

use yii\db\Migration;

class m160811_190056_stub_booking extends Migration
{
    public function up()
    {
		$this->alterColumn('{{%bookings}}', 'status', 'enum("Pending", "Approved", "Stub") NOT NULL');
    }

    public function down()
    {
		$this->alterColumn('{{%bookings}}', 'status', 'enum("Pending", "Approved", "Separator") NOT NULL');
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
