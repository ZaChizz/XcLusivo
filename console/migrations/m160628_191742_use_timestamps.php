<?php

use yii\db\Migration;


class m160628_191742_use_timestamps extends Migration
{


	public function up()
	{
		$this->execute('DELETE FROM {{%bookings}}');

		$this->alterColumn('{{%bookings}}', 'created_at', 'INT(11) UNSIGNED NOT NULL');
		$this->alterColumn('{{%bookings}}', 'updated_at', 'INT(11) UNSIGNED NOT NULL');
		$this->alterColumn('{{%bookings}}', 'from_date', 'INT(11) UNSIGNED NOT NULL');
		$this->alterColumn('{{%bookings}}', 'to_date', 'INT(11) UNSIGNED NOT NULL');
		
		$this->dropForeignKey('fk_booking_user', '{{%bookings}}');
		$this->addForeignKey('fk_booking_user', '{{%bookings}}', 'user_id', '{{%user}}', 'id', 'SET NULL', 'cascade');
	}


	public function down()
	{
		echo "\r\nNo actions needed to migrate down.";
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
