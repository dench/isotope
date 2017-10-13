<?php

use dench\language\models\Language;
use yii\db\Migration;

/**
 * Handles the creation of table `country`.
 */
class m171002_111853_create_country_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('country', [
            'id' => $this->string(2)->notNull(),
        ], $tableOptions);

        $this->createTable('country_lang', [
            'country_id' => $this->string(2)->notNull(),
            'lang_id' => $this->string(2)->notNull(),
            'name' => $this->string()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('id', 'country', 'id');

        $this->addPrimaryKey('pk-country_lang', 'country_lang', ['country_id', 'lang_id']);

        $this->addForeignKey('fk-country_lang-country_id', 'country_lang', 'country_id', 'country', 'id', 'CASCADE');

        $this->addForeignKey('fk-country_lang-lang_id', 'country_lang', 'lang_id', 'language', 'id', 'CASCADE', 'CASCADE');

        $langs = Language::nameList();

        $insert = [];
        $insert_lang = [];

        foreach ($langs as $lang_id => $lang) {
            $filename = __DIR__ . '/../vendor/umpirsky/country-list/data/' . $lang_id . '/country.json';
            if (file_exists($filename)) {
                $json = file_get_contents($filename);
                $data = json_decode($json, true);
                if (is_array($data)) {
                    foreach ($data as $key => $value) {
                        $insert[$key] = [$key];
                        $insert_lang[] = [
                            'country_id' => $key,
                            'lang_id' => $lang_id,
                            'name' => $value,
                        ];
                    }
                }
            }
        }

        $this->batchInsert('country', ['id'], $insert);
        $this->batchInsert('country_lang', ['country_id', 'lang_id', 'name'], $insert_lang);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-country_lang-lang_id', 'country_lang');

        $this->dropForeignKey('fk-country_lang-country_id', 'country_lang');

        $this->dropPrimaryKey('pk-country_lang', 'country_lang');

        $this->dropPrimaryKey('id', 'country');

        $this->dropTable('country_lang');

        $this->dropTable('country');
    }
}
