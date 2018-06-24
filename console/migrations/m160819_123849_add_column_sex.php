<?php

use yii\db\Migration;

class m160819_123849_add_column_sex extends Migration
{
    public function up()
    {
        $this->dropForeignKey('fk-advertiser_sex-adv_id', '{{%advertiser_sex}}');
        $this->dropTable('{{%advertiser_sex}}');
        $this->execute("ALTER TABLE {{%advertiser}} ADD `sex_id` INT(11) DEFAULT 0");
    }

    public function down()
    {
          $this->dropColumn('{{%advertiser}}', 'sex_id');
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
