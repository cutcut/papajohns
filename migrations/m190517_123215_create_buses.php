<?php

use yii\db\Migration;

/**
 * Class m190516_123215_create_buses
 */
class m190517_123215_create_buses extends Migration
{
    private $table = 'buses';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'avg_speed' => $this->integer()->notNull(),
        ]);

        $rows = [];

        $minSpeed = 80;
        $maxSpeed = 200;

        for ($i = 1; $i <= 20; $i++) {
            $rows[] = [
                'Bus ' . $i,
                rand($minSpeed, $maxSpeed),
            ];
        }

        $this->batchInsert($this->table, ['name', 'avg_speed'], $rows);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }

}
