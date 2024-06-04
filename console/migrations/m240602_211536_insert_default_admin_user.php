<?php

use yii\db\Migration;

class m240602_211536_insert_default_admin_user extends Migration
{
    private const TABLE = 'user';

    public function safeUp(): void
    {
        $this->insert(self::TABLE, [
            'username' => 'admin',
            'auth_key' => 'txOV1e5QfAAFwjD50XcJeNZR2Sged9of',
            'password_hash' => '$2y$10$b4X3SIhkr4HTbBhBH2LRA.f6Ln0EG7jskRk/f2Muip.t126jFfbUe',
            'email' => 'admin@example.ru',
            'created_at' => time(),
            'updated_at' => time(),
            'access_token' => 'rZkfr8iX2hkcust9lV5x2owoKHs7a3ESuPkaq0ERZ8VOhnqlicC4fKaR2bANcHtb',
        ]);
    }

    public function safeDown(): void
    {
        $this->truncateTable(self::TABLE);
    }
}
