<?php

use yii\db\Migration;

class m160718_133459_bra_add_groups extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE {{%bra}} ADD COLUMN `group` ENUM('big','medium','small') NOT NULL DEFAULT 'small' AFTER `title`");
        
        $this->update('{{%bra}}', array('group' => 'small'), 'title IN ("AA", "A")');
        $this->update('{{%bra}}', array('group' => 'medium'), 'title IN ("B", "C", "D")');
        $this->update('{{%bra}}', array('group' => 'big'), 'title IN ("F", "H", "G")');
    }

    public function down()
    {
        $this->dropColumn('{{%bra}}', 'group');
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
