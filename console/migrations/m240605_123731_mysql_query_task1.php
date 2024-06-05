<?php

use yii\db\Migration;

/**
 * Class m240605_123731_user_books
 */
class m240605_123731_mysql_query_task1 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string(100)->notNull(),
            'second_name' => $this->string(100)->notNull(),
            'birthday' => $this->date()->notNull()
        ]);

        $this->createTable('books', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100),
            'author' => $this->string(100)
        ]);

        $this->createTable('user_books', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'book_id' => $this->integer(),
            'get_date' => $this->date(),
            'return_date' => $this->date()
        ]);

        $this->insert('users', [
            'first_name' => 'Иван',
            'second_name' => 'Петров',
            'birthday'=> '2012-05-25'
        ]);

        $this->insert('users', [
            'first_name' => 'Кирилл',
            'second_name' => 'Ласточкин',
            'birthday'=> '1994-03-03'
        ]);

        $this->insert('users', [
            'first_name' => 'Светлана',
            'second_name' => 'Четкова',
            'birthday'=> '2008-03-21'
        ]);

        $this->insert('books', [
            'name' => 'Евгений Онегин',
            'author' => 'Александр Сергеевич Пушкин',
        ]);

        $this->insert('books', [
            'name' => 'Руслан и Людмила',
            'author' => 'Александр Сергеевич Пушкин',
        ]);

        $this->insert('books', [
            'name' => 'Война и мир',
            'author' => 'Лев Николаевич Толстой',
        ]);

        $this->insert('books', [
            'name' => 'Анна Каренина',
            'author' => 'Лев Николаевич Толстой',
        ]);

        $this->insert('books', [
            'name' => 'Преступление и наказание',
            'author' => 'Федор Михайлович Достоевский',
        ]);

        $this->insert('user_books', [
            'user_id' => 1,
            'book_id' => 1,
            'get_date'=> '2024-05-14',
            'return_date' => '2024-05-24'
        ]);

        $this->insert('user_books', [
            'user_id' => 1,
            'book_id' => 2,
            'get_date'=> '2024-04-12',
            'return_date' => '2024-04-25'
        ]);

        $this->insert('user_books', [
            'user_id' => 3,
            'book_id' => 3,
            'get_date'=> '2024-03-02',
            'return_date' => '2024-03-15'
        ]);

        $this->insert('user_books', [
            'user_id' => 3,
            'book_id' => 4,
            'get_date'=> '2024-02-11',
            'return_date' => '2024-02-25'
        ]);

        $this->insert('user_books', [
            'user_id' => 2,
            'book_id' => 5,
            'get_date'=> '2024-02-12',
            'return_date' => '2024-02-23'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable('user_books');
        $this->dropTable('books');
        $this->dropTable('users');
    }

}
