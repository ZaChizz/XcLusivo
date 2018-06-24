<?php

use yii\db\Migration;

class m160711_111304_add_eye_color extends Migration
{
    public function up()
    {
        $this->insert('{{%colors}}',array('type'=>2, 'title'=>'Honey', 'class'=>'color12'));
        $this->insert('{{%colors}}',array('type'=>2, 'title'=>'Brown', 'class'=>'color13'));
        $this->insert('{{%colors}}',array('type'=>2, 'title'=>'Green', 'class'=>'color8'));
        $this->insert('{{%colors}}',array('type'=>2, 'title'=>'Grey', 'class'=>'color9'));
        $this->insert('{{%colors}}',array('type'=>2, 'title'=>'Amethyst', 'class'=>'color12'));
    }

    public function down()
    {
        $this->delete('{{%colors}}',array('type'=>2));
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
