<?php

use yii\db\Schema;
use yii\db\Migration;

class m150420_185130_AT_news extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->addColumn('news','hash',Schema::TYPE_STRING);
        $this->createIndex('hash','news','hash',true);
    }
    
    public function safeDown()
    {
        $this->dropIndex('hash','news');
        $this->dropColumn('news','hash');
    }
}
