<?php

use yii\db\Migration;

class m160722_192025_add_column_payment_id extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE {{%advertiser}} ADD `payment_id` VARCHAR(25) NOT NULL DEFAULT ''");
    }

    public function down()
    {
        $this->dropColumn('{{%advertiser}}', 'payment_id');
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
