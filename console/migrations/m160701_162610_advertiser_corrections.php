<?php

use yii\db\Migration;

class m160701_162610_advertiser_corrections extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE {{%advertiser}} ADD `bra_id` INT(11) NOT NULL AFTER `skin_id`");
        $this->execute("ALTER TABLE {{%advertiser}} ADD `shoe_size` INT(11) NOT NULL AFTER `bra_id`");
        $this->execute("UPDATE `advertiser` SET `bra_id` = '1';");

        $this->addForeignKey('fk_bra_advertiser', '{{%advertiser}}', 'bra_id', '{{%bra}}', 'id', 'cascade', 'cascade');

    }

    public function down()
    {

        $this->dropForeignKey('fk_bra_advertiser', '{{%advertiser}}');
        $this->dropColumn('{{%advertiser}}', 'bra_id');
        $this->dropColumn('{{%advertiser}}', 'shoe_size');

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
