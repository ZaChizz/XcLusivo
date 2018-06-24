<?php

use yii\db\Migration;

class m160729_194228_add_admin_for_chat extends Migration
{
    public function up()
    {
          $this->execute("INSERT INTO {{%user}} (`id`, `username`, `created_at`, `updated_at`, `time_session`, `auth_key`, `password_hash`, `email`, `phone` ) VALUES (-1, 'Admin', 1, 1, 0, '', '', '', '')");
    }

    public function down()
    {
        $this->execute("DELETE FROM {{%user}} WHERE id = -1");
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
