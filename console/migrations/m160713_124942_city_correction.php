<?php

use yii\db\Migration;

class m160713_124942_city_correction extends Migration
{
    public function up()
    {
        $this->renameColumn('{{%city}}', 'city', 'title');
        $this->dropForeignKey('advertiser_ibfk_6', '{{%advertiser}}');
        $this->addForeignKey('advertiser_city', '{{%advertiser}}', 'cities_id', '{{%city}}', 'id', 'cascade', 'cascade');
        $this->addColumn('{{%advertiser}}', 'country_id', $this->integer('11')->notNull());
        $this->execute("UPDATE `advertiser` SET `cities_id` = '10090'");
        $this->execute("UPDATE `advertiser` SET `country_id` = '2'");
        $this->addForeignKey('advertiser_country', '{{%advertiser}}', 'country_id', '{{%country}}', 'id', 'cascade', 'cascade');

    }

    public function down()
    {
        $this->renameColumn('{{%city}}', 'title', 'city');
        $this->dropForeignKey('advertiser_city', '{{%advertiser}}');
        $this->dropForeignKey('advertiser_country', '{{%advertiser}}');
        $this->execute("UPDATE `advertiser` SET `cities_id` = '1'");
        $this->addForeignKey('advertiser_ibfk_6', '{{%advertiser}}', 'cities_id', '{{%cities}}', 'id', 'cascade', 'cascade');
        $this->dropColumn('{{%advertiser}}', 'country_id');

    }
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
