<?php

use yii\db\Migration;

class m160621_174648_advertiser_image extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%advertiser_image}}', [
            'id' => $this->primaryKey(),
            'id_advertiser' => $this->integer('11')->notNull(),
            'title' => $this->string('255')->notNull()->defaultValue(''),
            'resolution' => $this->string('255')->notNull()->defaultValue(''),
            'orientation' => $this->string('255')->notNull()->defaultValue(''),
        ], $tableOptions);

        $this->addForeignKey('advertiser_image_ibfk_1','{{%advertiser_image}}','id_advertiser','{{%advertiser}}','id','cascade','cascade');
    }

    public function down()
    {
		$this->dropForeignKey('advertiser_image_ibfk_1', '{{%advertiser_image}}');
		$this->dropTable('{{%advertiser_image}}');
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
