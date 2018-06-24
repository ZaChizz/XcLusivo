<?php

use yii\db\Migration;
use yii\db\Schema;


class m160820_211727_scores_basics extends Migration
{


	public function up()
	{
		$tableOptions = null;

		if ($this->db->driverName === 'mysql') {
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}

		$this->createTable('{{%scores}}', [
			'id' => Schema::TYPE_PK,
			'advertiser_id' => $this->integer(),
			'user_id' => $this->integer()->null(),
			'valid_until' => $this->integer()->unsigned()->notNull(),
			'amount' => $this->integer(),
			'entity_class' => $this->string(),
			'entity_id' => $this->integer()->null(),
			'custom_id' => $this->string()->null(),
			'created_at' => $this->integer()->unsigned()->notNull(),
			'updated_at' => $this->integer()->unsigned()->notNull(),
			'is_test' => $this->boolean(),
			], $tableOptions);

		$this->createIndex('idx_valid_until', '{{%scores}}', 'valid_until');
		$this->createIndex('idx_entity', '{{%scores}}', ['entity_class', 'entity_id']);
		$this->createIndex('idx_custom', '{{%scores}}', 'custom_id');
		$this->addForeignKey('fk_score_advertiser', '{{%scores}}', 'advertiser_id', '{{%advertiser}}', 'id', 'CASCADE', 'CASCADE');
		$this->addForeignKey('fk_score_user', '{{%scores}}', 'user_id', '{{%user}}', 'id', 'SET NULL', 'CASCADE');
	}


	public function down()
	{
		$this->dropForeignKey('fk_score_advertiser', '{{%scores}}');
		$this->dropForeignKey('fk_score_user', '{{%scores}}');
		$this->dropTable('{{%scores}}');
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
