<?php

use yii\db\Schema;
use yii\db\Migration;

class m150419_202229_CT_services extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable('service',[
                'id'=>Schema::TYPE_PK,
                'title'=>Schema::TYPE_STRING,
                'processor'=>Schema::TYPE_STRING,
                'url'=>Schema::TYPE_TEXT,
                'last_call'=>Schema::TYPE_DATETIME
            ]);
    }
    
    public function safeDown()
    {
        $this->dropTable('service');
    }
}
