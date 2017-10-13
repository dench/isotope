<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m171003_135839_create_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'ip' => $this->string(40)->notNull(),
            'country_id' => $this->string(2)->notNull()->defaultValue(''),
            'city' => $this->string(30),
            'birthday' => $this->date(),
            'sex' => $this->smallInteger(1)->defaultValue(0),
            'website' => $this->string(),
            'file_id' => $this->integer(),
            'timezone' => $this->string(30)->notNull()->defaultValue('UTC'),
            'email_news' => $this->boolean()->defaultValue(0),
            'email_notice' => $this->boolean()->defaultValue(0),
        ], $tableOptions);

        $this->addForeignKey('fk-user-country_id', 'user', 'country_id', 'country', 'id', 'CASCADE');

        $this->addForeignKey('fk-user-file_id', 'user', 'file_id', 'file', 'id', 'SET NULL');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-user-country_id', 'user');

        $this->dropForeignKey('fk-user-file_id', 'user');

        $this->dropTable('user');
    }
}
