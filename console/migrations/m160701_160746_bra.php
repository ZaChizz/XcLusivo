<?php

use yii\db\Migration;

class m160701_160746_bra extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%bra}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string('255')->notNull()->defaultValue(''),

        ], $tableOptions);

        $this->insert('{{%bra}}',array('title'=>'AA'));
        $this->insert('{{%bra}}',array('title'=>'A'));
        $this->insert('{{%bra}}',array('title'=>'B'));
        $this->insert('{{%bra}}',array('title'=>'C'));
        $this->insert('{{%bra}}',array('title'=>'D'));
        $this->insert('{{%bra}}',array('title'=>'F'));
        $this->insert('{{%bra}}',array('title'=>'G'));
        $this->insert('{{%bra}}',array('title'=>'H'));


        // $this->insert('{{%bra}}',array('title'=>'60AA'));
        // $this->insert('{{%bra}}',array('title'=>'60A'));
        // $this->insert('{{%bra}}',array('title'=>'60B'));
        // $this->insert('{{%bra}}',array('title'=>'60C'));
        // $this->insert('{{%bra}}',array('title'=>'60D'));
        // $this->insert('{{%bra}}',array('title'=>'60F'));
        // $this->insert('{{%bra}}',array('title'=>'60G'));
        // $this->insert('{{%bra}}',array('title'=>'60H'));

        // $this->insert('{{%bra}}',array('title'=>'65AA'));
        // $this->insert('{{%bra}}',array('title'=>'65A'));
        // $this->insert('{{%bra}}',array('title'=>'65B'));
        // $this->insert('{{%bra}}',array('title'=>'65C'));
        // $this->insert('{{%bra}}',array('title'=>'65D'));
        // $this->insert('{{%bra}}',array('title'=>'65F'));
        // $this->insert('{{%bra}}',array('title'=>'65G'));
        // $this->insert('{{%bra}}',array('title'=>'65H'));

        // $this->insert('{{%bra}}',array('title'=>'70AA'));
        // $this->insert('{{%bra}}',array('title'=>'70A'));
        // $this->insert('{{%bra}}',array('title'=>'70B'));
        // $this->insert('{{%bra}}',array('title'=>'70C'));
        // $this->insert('{{%bra}}',array('title'=>'70D'));
        // $this->insert('{{%bra}}',array('title'=>'70F'));
        // $this->insert('{{%bra}}',array('title'=>'70G'));
        // $this->insert('{{%bra}}',array('title'=>'70H'));

        // $this->insert('{{%bra}}',array('title'=>'75AA'));
        // $this->insert('{{%bra}}',array('title'=>'75A'));
        // $this->insert('{{%bra}}',array('title'=>'75B'));
        // $this->insert('{{%bra}}',array('title'=>'75C'));
        // $this->insert('{{%bra}}',array('title'=>'75D'));
        // $this->insert('{{%bra}}',array('title'=>'75F'));
        // $this->insert('{{%bra}}',array('title'=>'75G'));
        // $this->insert('{{%bra}}',array('title'=>'75H'));

        // $this->insert('{{%bra}}',array('title'=>'80AA'));
        // $this->insert('{{%bra}}',array('title'=>'80A'));
        // $this->insert('{{%bra}}',array('title'=>'80B'));
        // $this->insert('{{%bra}}',array('title'=>'80C'));
        // $this->insert('{{%bra}}',array('title'=>'80D'));
        // $this->insert('{{%bra}}',array('title'=>'80F'));
        // $this->insert('{{%bra}}',array('title'=>'80G'));
        // $this->insert('{{%bra}}',array('title'=>'80H'));

        // $this->insert('{{%bra}}',array('title'=>'85AA'));
        // $this->insert('{{%bra}}',array('title'=>'85A'));
        // $this->insert('{{%bra}}',array('title'=>'85B'));
        // $this->insert('{{%bra}}',array('title'=>'85C'));
        // $this->insert('{{%bra}}',array('title'=>'85D'));
        // $this->insert('{{%bra}}',array('title'=>'85F'));
        // $this->insert('{{%bra}}',array('title'=>'85G'));
        // $this->insert('{{%bra}}',array('title'=>'85H'));

        // $this->insert('{{%bra}}',array('title'=>'90AA'));
        // $this->insert('{{%bra}}',array('title'=>'90A'));
        // $this->insert('{{%bra}}',array('title'=>'90B'));
        // $this->insert('{{%bra}}',array('title'=>'90C'));
        // $this->insert('{{%bra}}',array('title'=>'90D'));
        // $this->insert('{{%bra}}',array('title'=>'90F'));
        // $this->insert('{{%bra}}',array('title'=>'90G'));
        // $this->insert('{{%bra}}',array('title'=>'90H'));

        // $this->insert('{{%bra}}',array('title'=>'95AA'));
        // $this->insert('{{%bra}}',array('title'=>'95A'));
        // $this->insert('{{%bra}}',array('title'=>'95B'));
        // $this->insert('{{%bra}}',array('title'=>'95C'));
        // $this->insert('{{%bra}}',array('title'=>'95D'));
        // $this->insert('{{%bra}}',array('title'=>'95F'));
        // $this->insert('{{%bra}}',array('title'=>'95G'));
        // $this->insert('{{%bra}}',array('title'=>'95H'));

        // $this->insert('{{%bra}}',array('title'=>'100AA'));
        // $this->insert('{{%bra}}',array('title'=>'100A'));
        // $this->insert('{{%bra}}',array('title'=>'100B'));
        // $this->insert('{{%bra}}',array('title'=>'100C'));
        // $this->insert('{{%bra}}',array('title'=>'100D'));
        // $this->insert('{{%bra}}',array('title'=>'100F'));
        // $this->insert('{{%bra}}',array('title'=>'100G'));
        // $this->insert('{{%bra}}',array('title'=>'100H'));

        // $this->insert('{{%bra}}',array('title'=>'105AA'));
        // $this->insert('{{%bra}}',array('title'=>'105A'));
        // $this->insert('{{%bra}}',array('title'=>'105B'));
        // $this->insert('{{%bra}}',array('title'=>'105C'));
        // $this->insert('{{%bra}}',array('title'=>'105D'));
        // $this->insert('{{%bra}}',array('title'=>'105F'));
        // $this->insert('{{%bra}}',array('title'=>'105G'));
        // $this->insert('{{%bra}}',array('title'=>'105H'));


    }

    public function down()
    {
        echo "m160701_160746_bra cannot be reverted.\n";

        return false;
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
