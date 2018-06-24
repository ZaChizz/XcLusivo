<?php

use yii\db\Migration;


class m160607_185303_reviews extends Migration
{


	public function up()
	{
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			// http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}

		$this->createTable('{{%reviews}}', [
			'id'		 => $this->primaryKey(),
			'id_from'	 => $this->integer('11')->notNull(),
			'id_to'		 => $this->integer('11')->notNull(),
			'title'		 => $this->text('')->notNull()->defaultValue(''),
			'date_add'	 => $this->integer('11')->notNull()
			], $tableOptions);


		$this->addForeignKey('reviews_ibfk_1', '{{%reviews}}', 'id_from', '{{%user}}', 'id', 'cascade', 'cascade');
		$this->addForeignKey('reviews_ibfk_2', '{{%reviews}}', 'id_to', '{{%user}}', 'id', 'cascade', 'cascade');

		$this->createTable('{{%replys}}', [
			'id'		 => $this->primaryKey(),
			'id_from'	 => $this->integer('11')->notNull(),
			'id_review'	 => $this->integer('11')->notNull(),
			'title'		 => $this->text('')->notNull()->defaultValue(''),
			'date_add'	 => $this->integer('11')->notNull()
			], $tableOptions);


		$this->addForeignKey('replys_ibfk_1', '{{%replys}}', 'id_from', '{{%user}}', 'id', 'cascade', 'cascade');
		$this->addForeignKey('replys_ibfk_2', '{{%replys}}', 'id_review', '{{%reviews}}', 'id', 'cascade', 'cascade');
	}


	public function down()
	{
		$this->dropForeignKey('replys_ibfk_1', '{{%replys}}');
		$this->dropForeignKey('replys_ibfk_2', '{{%replys}}');

		$this->dropTable('{{%replys}}');

		$this->addForeignKey('reviews_ibfk_1', '{{%reviews}}');
		$this->addForeignKey('reviews_ibfk_2', '{{%reviews}}');

		$this->dropTable('{{%reviews}}');


		echo "m160607_185303_reviews down success .\n";

		return true;
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
