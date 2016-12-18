<?php

use yii\db\Migration;

class m161217_214410_table_layoutModules extends Migration
{
    public $table = '{{%layout_module}}';

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'layout_id' => $this->integer()->notNull(), // id страницы для вывода нашего модуля
            'module' => $this->string(150)->notNull(),  //название модуля
            'status' => $this->boolean()->defaultValue(true),
            'position' => $this->string(30)->notNull(),
            'sort_order' => $this->integer()->defaultValue(1),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
