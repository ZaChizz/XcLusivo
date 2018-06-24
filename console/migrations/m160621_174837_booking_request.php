<?php

use yii\db\Migration;


class m160621_174837_booking_request extends Migration
{


	public function up()
	{
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			// http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}

		$this->createTable('{{%booking_requests}}', [
			'id'				 => $this->primaryKey(),
			'advertiser_id'		 => $this->integer('11')->notNull(),
			'nonadvertiser_id'	 => $this->integer('11')->notNull(),
			'request_status'	 => $this->integer('11')->notNull(),
			'pay_with'			 => $this->integer('11')->notNull(),
			'secure_booking'	 => $this->smallInteger('1')->notNull(),
			'from_date'			 => $this->string('255')->notNull()->defaultValue(''),
			'to_date'			 => $this->string('255')->notNull()->defaultValue(''),
			'alert'				 => $this->smallInteger('1')->notNull(),
			'create_at'			 => $this->integer('11')->notNull(),
			], $tableOptions);

		$this->addForeignKey('booking_requests_ibfk_1', '{{%booking_requests}}', 'pay_with', '{{%payment_methods}}', 'id', 'cascade', 'cascade');
		$this->addForeignKey('booking_requests_ibfk_2', '{{%booking_requests}}', 'advertiser_id', '{{%advertiser}}', 'id', 'cascade', 'cascade');
		$this->addForeignKey('booking_requests_ibfk_3', '{{%booking_requests}}', 'nonadvertiser_id', '{{%user}}', 'id', 'cascade', 'cascade');
	}


	public function down()
	{
		$this->dropForeignKey('booking_requests_ibfk_1', '{{%booking_requests}}');
		$this->dropForeignKey('booking_requests_ibfk_2', '{{%booking_requests}}');
		$this->dropForeignKey('booking_requests_ibfk_3', '{{%booking_requests}}');
		$this->dropTable('{{%booking_requests}}');
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
