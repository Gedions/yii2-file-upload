<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%file}}`.
 */
class m231113_135549_create_files_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%files}}', [
            'ID' => $this->primaryKey(),
            'FileData' => 'VARBINARY(MAX) NOT NULL',
            'FileName' => $this->string(255)->notNull(),
            'FileType' => $this->string(255)->notNull(),
            'FileSize' => $this->string(255)->notNull(),
            'ContentType' => $this->string(255)->notNull(),
            'CreatedBy' => $this->integer(),
            'CreatedAt' => $this->dateTime()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%files}}');
    }
}
