<?php

use yii\db\Schema;
use yii\db\Migration;

class m160205_222013_add_superadmin extends Migration
{
    public function up()
    {
        $this->insert('{{%admins}}',array(
            'username' =>'superadmin',
            'auth_key' => 'l0egTdMk_sdPmfqzxIvjagTXcLk_7Fbr',
            'password_hash' => '$2y$13$NbLMq6TI7MMkdwOJS7cVPOGv/rFq0Ixbfxgpqr7y4b80VxulK4YyO',
            'password_reset_token' => '',
            'email' => 'admin@example.com',
            'status' => 10,
            'role' => 0,
            'created_at' => 1454707791,
            'updated_at' => 1454707791,
        ));
    }

    public function down()
    {
        echo "m160205_222013_add_superadmin cannot be reverted.\n";

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
