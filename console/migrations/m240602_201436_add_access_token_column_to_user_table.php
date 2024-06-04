<?php

use yii\db\Migration;

class m240602_201436_add_access_token_column_to_user_table extends Migration
{
    private const
        TABLE = 'user',
        COLUMN = 'access_token';

    public function safeUp(): void
    {
        $this->addColumn(
            self::TABLE,
            self::COLUMN,
            $this->string(64)->null()->defaultValue(null)->unique(),
        );
    }

    public function safeDown(): void
    {
        $this->dropColumn(self::TABLE, self::COLUMN);
    }
}
