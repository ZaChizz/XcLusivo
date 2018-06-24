<?php

use yii\db\Migration;

class m160712_124221_country extends Migration
{
    public function up()
    {
        /*----- Get Countries from VK ------*/

        $lang = 3; // english
        $headerOptions = array(
            'http' => array(
                'method' => "GET",
                'header' => "Accept-language: en\r\n" .
                    "Cookie: remixlang=$lang\r\n"
            )
        );
        $methodUrl = 'http://api.vk.com/method/database.getCountries?v=5.5&need_all=1&count=1000';
        $streamContext = stream_context_create($headerOptions);
        $json = file_get_contents($methodUrl, false, $streamContext);
        $arr = json_decode($json, true);
        //echo 'Total countries count: ' . $arr['response']['count'] . ' loaded: ' . count($arr['response']['items']);

        /*----- Set to DB -----*/

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%country}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string('255')->notNull()
        ], $tableOptions);

        foreach($arr['response']['items'] as $value)
        {
            $this->insert('{{%country}}',array('id'=>$value['id'], 'title'=>$value['title']));
        }

    }

    public function down()
    {
        $this->delete('{{%country}}');
        $this->dropTable('{{%country}}');
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
