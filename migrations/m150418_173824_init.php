<?php

use yii\db\Schema;
use yii\db\Migration;

class m150418_173824_init extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable('tag',[
                'id'=>Schema::TYPE_PK,
                'title'=>Schema::TYPE_STRING,
            ]);
        $this->createTable('news',[
                'id'=>Schema::TYPE_PK,
                'title'=>Schema::TYPE_STRING,
                'date_create'=>Schema::TYPE_DATETIME,
                'content'=>Schema::TYPE_TEXT,
                'url'=>Schema::TYPE_TEXT
            ]);
        $this->createTable('news2tags',[
                'news_id'=>Schema::TYPE_INTEGER,
                'tag_id'=>Schema::TYPE_INTEGER,
            ]);
        $this->addPrimaryKey('primary','news2tags',['news_id','tag_id']);
        $this->addForeignKey('news','news2tags','news_id','news','id','CASCADE','NO ACTION');
        $this->addForeignKey('tags','news2tags','tag_id','tag','id','CASCADE','NO ACTION');
    }

    public function safeDown()
    {
        $this->dropForeignKey('tags','news');
        $this->dropForeignKey('news','tags');
        $this->dropTable('tags');
        $this->dropTable('news');
        $this->dropTable('news2tags');
    }
}
