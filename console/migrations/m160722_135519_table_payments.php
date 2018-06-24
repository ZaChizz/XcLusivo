<?php

use yii\db\Migration;

class m160722_135519_table_payments extends Migration
{
    public function safeUp()
    {
      $tableOptions = null;
      if ($this->db->driverName === 'mysql') {
          $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
      }

      $this->createTable('{{%payments_list}}', [
          'payment_id' => $this->string(25)->notNull(),
          'enabled_for_payment' => 'TINYINT(1) UNSIGNED DEFAULT 0',
          'enabled_for_payout' => 'TINYINT(1) UNSIGNED DEFAULT 0',
          'UNIQUE KEY `payment_id` (`payment_id`)',
          'KEY `enabled_for_payment` (`enabled_for_payment`)',
          'KEY `enabled_for_payout` (`enabled_for_payout`)',
      ], $tableOptions);

      $this->createTable('{{%payments_country}}', [
          'payment_id' => $this->string(25)->notNull(),
          'country_id' => 'INT(11)',
          'KEY `payment_id` (`payment_id`)',
          'KEY `country_id` (`country_id`)',
      ], $tableOptions);

      $this->addForeignKey('fk_countries_to_payments', '{{%payments_country}}', 'payment_id', '{{%payments_list}}', 'payment_id', 'cascade', 'cascade');
    }

    public function safeDown()
    {
      $this->dropForeignKey('fk_countries_to_payments', '{{%payments_country}}');
      $this->dropTable('{{%payments_list}}');
      $this->dropTable('{{%payments_country}}');
    }

}
