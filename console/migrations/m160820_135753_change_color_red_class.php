<?php

use yii\db\Migration;

class m160820_135753_change_color_red_class extends Migration
{
    public function up()
    {
        $this->update('{{%colors}}', ['class' => 'color3'], 'title="Red"');
    }

    public function down()
    {
        $this->update('{{%colors}}', ['class' => 'color1'], 'title="Red"');
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
