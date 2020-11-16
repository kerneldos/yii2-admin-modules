<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%module}}`.
 */
class m191213_141820_create_module_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%module}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'class' => $this->string()->notNull()->unique(),
            'is_active' => $this->boolean()->null()->defaultValue(true),
            'is_bootstrap' => $this->boolean()->null()->defaultValue(false),
            'is_main' => $this->boolean()->null()->defaultValue(false),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%module}}');
    }
}
