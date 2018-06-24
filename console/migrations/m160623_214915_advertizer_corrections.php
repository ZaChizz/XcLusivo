<?php

use yii\db\Migration;


class m160623_214915_advertizer_corrections extends Migration
{


	public function up()
	{
		try {
			$this->dropForeignKey('advertiser_ibfk_2', '{{%advertiser}}');
		} catch (yii\db\Exception $e) {
			//FK does not exist for some reason
		}

		$this->alterColumn('{{%advertiser}}', 'hair_id', 'INT(11) NULL DEFAULT NULL');
		$this->addForeignKey('advertiser_ibfk_2', '{{%advertiser}}', 'hair_id', '{{colors}}', 'id', 'SET NULL', 'cascade');

		try {
			$this->dropForeignKey('advertiser_ibfk_3', '{{%advertiser}}');
		} catch (yii\db\Exception $e) {
			//FK does not exist for some reason
		}

		$this->alterColumn('{{%advertiser}}', 'eye_id', 'INT(11) NULL DEFAULT NULL');
		$this->addForeignKey('advertiser_ibfk_3', '{{%advertiser}}', 'eye_id', '{{colors}}', 'id', 'SET NULL', 'cascade');

		try {
			$this->dropForeignKey('advertiser_ibfk_4', '{{%advertiser}}');
		} catch (yii\db\Exception $e) {
			//FK does not exist for some reason
		}

		$this->alterColumn('{{%advertiser}}', 'skin_id', 'INT(11) NULL DEFAULT NULL');
		$this->addForeignKey('advertiser_ibfk_4', '{{%advertiser}}', 'skin_id', '{{colors}}', 'id', 'SET NULL', 'cascade');

		try {
			$this->dropForeignKey('advertiser_ibfk_5', '{{%advertiser}}');
		} catch (yii\db\Exception $e) {
			//FK does not exist for some reason
		}

		$this->alterColumn('{{%advertiser}}', 'nationality_id', 'INT(11) NULL DEFAULT NULL');
		$this->addForeignKey('advertiser_ibfk_5', '{{%advertiser}}', 'nationality_id', '{{nationality}}', 'id', 'SET NULL', 'cascade');

		try {
			$this->dropForeignKey('advertiser_ibfk_6', '{{%advertiser}}');
		} catch (yii\db\Exception $e) {
			//FK does not exist for some reason
		}

		$this->alterColumn('{{%advertiser}}', 'cities_id', 'INT(11) NULL DEFAULT NULL');
		$this->addForeignKey('advertiser_ibfk_6', '{{%advertiser}}', 'cities_id', '{{cities}}', 'id', 'SET NULL', 'cascade');

		$this->alterColumn('{{%advertiser}}', 'height', 'INT(11) NULL DEFAULT NULL');
		$this->alterColumn('{{%advertiser}}', 'weight', 'INT(11) NULL DEFAULT NULL');
		$this->alterColumn('{{%advertiser}}', 'date', 'VARCHAR(255) NULL DEFAULT NULL');
		$this->alterColumn('{{%advertiser}}', 'age', 'INT(11) UNSIGNED NULL DEFAULT NULL');
		$this->alterColumn('{{%advertiser}}', 'silicone', 'TINYINT(1) NOT NULL DEFAULT 1');
		$this->alterColumn('{{%advertiser}}', 'online', 'TINYINT(1) NOT NULL DEFAULT 0');
		$this->alterColumn('{{%advertiser}}', 'title', 'VARCHAR(255) NULL DEFAULT NULL');
		$this->alterColumn('{{%advertiser}}', 'price', 'DECIMAL(10,2) NULL DEFAULT NULL');

		try {
			$this->dropIndex('idx_age', '{{%advertiser}}');
		} catch (yii\db\Exception $e) {
			//Index does not exist for some reason
		}

		$this->createIndex('idx_age', '{{%advertiser}}', 'age', false);
	}


	/*
	  $this->addForeignKey('advertiser_ibfk_2','advertiser','hair_id','colors','id','cascade','cascade');
	  $this->addForeignKey('advertiser_ibfk_3','advertiser','eye_id','colors','id','cascade','cascade');
	  $this->addForeignKey('advertiser_ibfk_4','advertiser','skin_id','colors','id','cascade','cascade');
	  $this->addForeignKey('advertiser_ibfk_5','advertiser','nationality_id','nationality','id','cascade','cascade');
	  $this->addForeignKey('advertiser_ibfk_6','advertiser','cities_id','cities','id','cascade','cascade');
	 */


	public function down()
	{
		echo "\r\n No changes require to migrate down\r\n";
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
