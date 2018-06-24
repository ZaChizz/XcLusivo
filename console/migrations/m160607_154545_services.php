<?php

use yii\db\Migration;

class m160607_154545_services extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%services}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string('255')->notNull()->defaultValue(''),
        ], $tableOptions);

        $this->insert('{{%services}}',array('title'=>'69'));
        $this->insert('{{%services}}',array('title'=>'Advanced'));
        $this->insert('{{%services}}',array('title'=>'American'));
        $this->insert('{{%services}}',array('title'=>'Cum in mouth'));
        $this->insert('{{%services}}',array('title'=>'Classic Cocktail'));
        $this->insert('{{%services}}',array('title'=>'COB'));
        $this->insert('{{%services}}',array('title'=>'Cum On Face'));
        $this->insert('{{%services}}',array('title'=>'Couples'));
        $this->insert('{{%services}}',array('title'=>'Danish /Missionary Position'));
        $this->insert('{{%services}}',array('title'=>'Deep Throa'));
        $this->insert('{{%services}}',array('title'=>'Dominance: Money'));
        $this->insert('{{%services}}',array('title'=>'Dominance: Slave'));
        $this->insert('{{%services}}',array('title'=>'Dutch/Foot'));
        $this->insert('{{%services}}',array('title'=>'Sex'));
        $this->insert('{{%services}}',array('title'=>'Erotic massage'));
        $this->insert('{{%services}}',array('title'=>'Body massage'));
        $this->insert('{{%services}}',array('title'=>'Escortdate/sexdate'));
        $this->insert('{{%services}}',array('title'=>'Fetish-fashion'));
        $this->insert('{{%services}}',array('title'=>'Fingersex'));
        $this->insert('{{%services}}',array('title'=>'French'));
        $this->insert('{{%services}}',array('title'=>'Girl Friend Experience  (GFE)'));
        $this->insert('{{%services}}',array('title'=>'Greek (anal sex)'));
        $this->insert('{{%services}}',array('title'=>'Jeans'));
        $this->insert('{{%services}}',array('title'=>'Domination'));



    }

    public function down()
    {

        if(!$this->dropTable('{{%services}}')){

            echo "m160607_154545_services cannot be reverted.\n";

            return false;
        }
        else{

            echo "m160607_154545_services down success .\n";

            return true;
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
}
