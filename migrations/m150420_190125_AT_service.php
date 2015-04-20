<?php

use yii\db\Schema;
use yii\db\Migration;

class m150420_190125_AT_service extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->addColumn('service','item_class',Schema::TYPE_STRING);
    }
    
    public function safeDown()
    {
        $this->dropColumn('service','item_class');
    }
}
