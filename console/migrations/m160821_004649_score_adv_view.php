<?php

use yii\db\Migration;

class m160821_004649_score_adv_view extends Migration
{
    public function up()
    {
		$sql = 
			'CREATE OR REPLACE VIEW {{%advertiser_scores}} AS '
			. 'SELECT advertiser_id, SUM(amount) as amount_sum FROM {{%scores}} '
			. 'WHERE valid_until>UNIX_TIMESTAMP() '
			. 'GROUP BY advertiser_id';
		$this->execute($sql);
    }

    public function down()
    {
		$this->execute('DROP VIEW IF EXISTS {{%advertiser_scores}}');
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
