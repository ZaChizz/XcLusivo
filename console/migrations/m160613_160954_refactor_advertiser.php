<?php

use yii\db\Migration;

class m160613_160954_refactor_advertiser extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%advertiser}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer('11')->notNull(),
            'title' => $this->string('255')->notNull()->defaultValue(''),
            'price' => $this->integer('11')->notNull(),
            'date' => $this->string('255')->notNull()->defaultValue(''),
            'age' => $this->integer('11')->notNull(),
            'height' => $this->integer('11')->notNull(),
            'weight' => $this->integer('11')->notNull(),
            'hair_id' => $this->integer('11')->notNull(),
            'eye_id' => $this->integer('11')->notNull(),
            'skin_id' => $this->integer('11')->notNull(),
            'silicone' => $this->smallInteger('3')->notNull(),
            'nationality_id' => $this->integer('11')->notNull(),
            'cities_id' => $this->integer('11')->notNull(),
            'offering' => $this->string('255')->notNull(),
            'receiving' => $this->string('255')->notNull(),
            'desc' => $this->text(),
            'online' => $this->smallInteger('3')->notNull(),
        ], $tableOptions);

        $this->addForeignKey('advertiser_ibfk_1','{{%advertiser}}','user_id','{{%user}}','id','cascade','cascade');
        $this->addForeignKey('advertiser_ibfk_2','{{%advertiser}}','hair_id','{{%colors}}','id','cascade','cascade');
        $this->addForeignKey('advertiser_ibfk_3','{{%advertiser}}','eye_id','{{%colors}}','id','cascade','cascade');
        $this->addForeignKey('advertiser_ibfk_4','{{%advertiser}}','skin_id','{{%colors}}','id','cascade','cascade');
        $this->addForeignKey('advertiser_ibfk_5','{{%advertiser}}','nationality_id','{{%nationality}}','id','cascade','cascade');
        $this->addForeignKey('advertiser_ibfk_6','{{%advertiser}}','cities_id','{{%cities}}','id','cascade','cascade');
    }

    public function down()
    {

        $this->dropForeignKey('advertiser_ibfk_1','{{%advertiser}}');
        $this->dropForeignKey('advertiser_ibfk_2','{{%advertiser}}');
        $this->dropForeignKey('advertiser_ibfk_3','{{%advertiser}}');
        $this->dropForeignKey('advertiser_ibfk_4','{{%advertiser}}');
        $this->dropForeignKey('advertiser_ibfk_5','{{%advertiser}}');
        $this->dropForeignKey('advertiser_ibfk_6','{{%advertiser}}');
		
        $this->dropTable('{{%advertiser}}');

       // echo "m160613_160954_refactor_advertiser cannot be reverted.\n";

        //return false;
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
