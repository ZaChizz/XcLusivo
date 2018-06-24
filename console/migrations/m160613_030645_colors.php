<?php

use yii\db\Migration;

class m160613_030645_colors extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%colors}}', [
            'id' => $this->primaryKey(),
            'type' => $this->integer('3')->notNull(),
            'title' => $this->string('255')->notNull(),
            'class' => $this->string('255')->notNull()
        ], $tableOptions);

        $this->insert('{{%colors}}',array('title'=>'Blonde','type'=>1,'class'=>'color2'));
        $this->insert('{{%colors}}',array('title'=>'Gray','type'=>2,'class'=>'color6'));
        $this->insert('{{%colors}}',array('title'=>'Light','type'=>3,'class'=>'color10'));
        $this->insert('{{%colors}}',array('title'=>'Brunette','type'=>1,'class'=>'color5'));
        $this->insert('{{%colors}}',array('title'=>'Brown-haired','type'=>1,'class'=>'color1'));


    }

    public function down()
    {
        $this->dropTable('{{%colors}}');

        echo "m160613_030645_colors cannot be reverted.\n";

        return true;
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
