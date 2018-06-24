<?php

use yii\db\Migration;

class m160531_102224_payment_methods extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%payment_methods}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string('255')->notNull()->defaultValue(''),

        ], $tableOptions);

        $this->insert('{{%payment_methods}}',array('title'=>'Visa'));
        $this->insert('{{%payment_methods}}',array('title'=>'PayPal'));
        $this->insert('{{%payment_methods}}',array('title'=>'Cash'));

    }

    public function down()
    {
        if(!$this->dropTable('{{%payment_methods}}')){

            echo "m160531_102224_payment_methods cannot be reverted.\n";

            return false;
        }
        else{

            echo "m160531_102224_payment_methods down success .\n";

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
