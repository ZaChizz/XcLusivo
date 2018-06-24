<?php

use yii\db\Migration;

/**
 * Handles the dropping for table `fk_key_advertiser_city`.
 */
class m160724_210452_drop_fk_key_advertiser_city extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
          $this->dropForeignKey('advertiser_city','{{%advertiser}}');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
          $this->addForeignKey('advertiser_city','{{%advertiser}}','cities_id','{{%cities}}','id','cascade','cascade');
    }
}
