<?php

use yii\db\Migration;

/**
 * Handles the creation for table `media`.
 */
class m160630_194727_create_media_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%media}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'hash' => $this->string(32)->notNull(),
            'is_default' => 'tinyint(1) NOT NULL DEFAULT 0',
        ], $tableOptions);
        
        $this->addForeignKey('media_ibfk_1', '{{%media}}', 'user_id', '{{%user}}', 'id', 'cascade', 'cascade');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('media_ibfk_1', '{{%media}}');
        $this->dropTable('{{%media}}');
    }
}
