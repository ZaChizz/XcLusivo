<?php

use yii\db\Migration;

class m160711_121449_add_hair_color extends Migration
{
    public function up()
    {
        $this->insert('{{%colors}}',array('type'=>1, 'title'=>'Black', 'class'=>'color5'));
        $this->insert('{{%colors}}',array('type'=>1, 'title'=>'Blonde', 'class'=>'color10'));
        $this->insert('{{%colors}}',array('type'=>1, 'title'=>'Brown/Brunette', 'class'=>'color7'));
        $this->insert('{{%colors}}',array('type'=>1, 'title'=>'Red', 'class'=>'color1'));
        $this->insert('{{%colors}}',array('type'=>1, 'title'=>'Grey', 'class'=>'color9'));
    }

    public function down()
    {
        $this->delete('{{%colors}}',array('type'=>1));
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
