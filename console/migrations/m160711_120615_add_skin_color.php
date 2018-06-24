<?php

use yii\db\Migration;

class m160711_120615_add_skin_color extends Migration
{
    public function up()
    {
        $this->insert('{{%colors}}',array('type'=>3, 'title'=>'Light', 'class'=>'color10'));
        $this->insert('{{%colors}}',array('type'=>3, 'title'=>'White', 'class'=>'color11'));
        $this->insert('{{%colors}}',array('type'=>3, 'title'=>'Medium', 'class'=>'color12'));
        $this->insert('{{%colors}}',array('type'=>3, 'title'=>'Brown', 'class'=>'color1'));
        $this->insert('{{%colors}}',array('type'=>3, 'title'=>'Black', 'class'=>'color5'));
    }

    public function down()
    {
        $this->delete('{{%colors}}',array('type'=>3));
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
