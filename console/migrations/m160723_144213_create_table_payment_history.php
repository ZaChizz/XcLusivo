<?php

use yii\db\Migration;

/**
 * Handles the creation for table `table_payment_history`.
 */
class m160723_144213_create_table_payment_history extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%payment_history}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
            'payer_id' => 'INT(11) NOT NULL',
            'receiver_id' => 'INT(11) NOT NULL',
            'amount' => 'DECIMAL(10,2) NOT NULL',
            'currency' => 'VARCHAR(3) NOT NULL',
            'status' => 'ENUM("WAIT","ACCEPTED","CANCELED") NOT NULL',
            'payment_id' => $this->string(25)->notNull(),
            'KEY `payer_id` (`payer_id`)',
            'KEY `receiver_id` (`receiver_id`)',
            'KEY `status` (`status`)'
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%payment_history}}');
    }
}
