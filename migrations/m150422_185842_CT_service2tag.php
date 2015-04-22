<?php

use yii\db\Schema;
use yii\db\Migration;

class m150422_185842_CT_service2tag extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable('service2tag',[
                'service_id'=>Schema::TYPE_INTEGER,
                'tag_id'=>Schema::TYPE_INTEGER,
            ]);
        $this->addPrimaryKey('index','service2tag',['service_id','tag_id']);
        $this->addForeignKey('service','service2tag','service_id','service','id','CASCADE','NO ACTION');
        $this->addForeignKey('tag','service2tag','tag_id','tag','id','CASCADE','NO ACTION');
    }
    
    public function safeDown()
    {
        $this->dropTable('service2tag');
    }
}
