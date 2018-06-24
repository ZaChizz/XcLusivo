<?php

use yii\db\Migration;

class m160802_194147_fix_advertiser_table extends Migration
{
    public function up()
    {
      $this->execute("ALTER TABLE {{%advertiser}}
        CHANGE COLUMN `bra_id` `bra_id` INT(11) NOT NULL DEFAULT '0',
        CHANGE COLUMN `shoe_size` `shoe_size` INT(11) NOT NULL DEFAULT '0',
        CHANGE COLUMN `country_id` `country_id` INT(11) NOT NULL DEFAULT '0'");

        $this->dropForeignKey('advertiser_country', '{{%advertiser}}');
        $this->dropForeignKey('fk_bra_advertiser', '{{%advertiser}}');
    }

    public function down()
    {
      $this->execute("ALTER TABLE {{%advertiser}}
        CHANGE COLUMN `bra_id` `bra_id` INT(11) NOT NULL,
       	CHANGE COLUMN `shoe_size` `shoe_size` INT(11) NOT NULL,
        CHANGE COLUMN `country_id` `country_id` INT(11) NOT NULL");

        $this->addForeignKey('advertiser_country', '{{%advertiser}}', 'country_id', '{{%country}}', 'id', 'cascade', 'cascade');
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
