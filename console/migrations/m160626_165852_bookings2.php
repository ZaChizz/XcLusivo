<?php

use yii\db\Migration;


class m160626_165852_bookings2 extends Migration
{


	public function up()
	{
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			// http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}

		$this->createTable('{{%bookings}}', [
			'id'			 => $this->primaryKey(),
			'advertiser_id'	 => $this->integer('11'),
			'user_id'		 => $this->integer('11'),
			'status'		 => 'enum("Pending", "Approved", "Separator") NOT NULL',
			'from_date'		 => $this->dateTime()->notNull(),
			'to_date'		 => $this->dateTime()->notNull(),
			'created_at'	 => $this->dateTime()->notNull(),
			'updated_at'	 => $this->dateTime()->notNull(),
			], $tableOptions);

		$this->addForeignKey('fk_booking_advertiser', '{{%bookings}}', 'advertiser_id', '{{%advertiser}}', 'id', 'SET NULL', 'cascade');
		$this->addForeignKey('fk_booking_user', '{{%bookings}}', 'user_id', '{{%advertiser}}', 'id', 'SET NULL', 'cascade');
	}


	public function down()
	{
		$this->dropForeignKey('fk_booking_advertiser', '{{%bookings}}');
		$this->dropForeignKey('fk_booking_user', '{{%bookings}}');
		
		$this->dropTable('{{%bookings}}');
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
