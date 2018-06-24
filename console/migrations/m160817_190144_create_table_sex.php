<?php

use yii\db\Migration;

class m160817_190144_create_table_sex extends Migration
{
    public function safeUp()
    {
      $tableOptions = null;
      if ($this->db->driverName === 'mysql') {
          $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
      }

      $this->createTable('{{%sex}}', [
          'id' => $this->primaryKey(),
          'title' => 'VARCHAR(20) NOT NULL DEFAULT ""',
      ]);
      $this->insert('{{%sex}}', ['title' => 'Girls']);
      $this->insert('{{%sex}}', ['title' => 'Boys']);
      $this->insert('{{%sex}}', ['title' => 'Gays']);
      $this->insert('{{%sex}}', ['title' => 'Agencies']);
      $this->insert('{{%sex}}', ['title' => 'Couples']);
      $this->insert('{{%sex}}', ['title' => 'Duos']);
      $this->insert('{{%sex}}', ['title' => 'Tv-Ts']);

      $this->createTable('{{%advertiser_sex}}', [
          'adv_id' => 'INT(11) NOT NULL',
          'sex_id' => 'INT(11) NOT NULL',
          'PRIMARY KEY (`adv_id`, `sex_id`)',
          'INDEX `adv_id` (`adv_id`)',
          'INDEX `sex_id` (`sex_id`)'
      ]);
      $this->addForeignKey('fk-advertiser_sex-adv_id', '{{%advertiser_sex}}', 'adv_id', '{{%advertiser}}', 'id', 'CASCADE');
    }

    public function safeDown()
    {
      $this->dropForeignKey('fk-advertiser_sex-adv_id', '{{%advertiser_sex}}');
      $this->dropTable('{{%advertiser_sex}}');
      $this->dropTable('{{%sex}}');
    }
}
