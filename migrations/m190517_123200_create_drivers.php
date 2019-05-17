<?php

use yii\db\Migration;

/**
 * Class m190516_123200_create_drivers
 */
class m190517_123200_create_drivers extends Migration
{
    private $table = 'drivers';

    /**
     * {@inheritdoc}
     * @throws Exception
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'birthday' => $this->date()->notNull(),
        ]);

        $rows = [];

        for ($i = 1; $i <= 366; $i++) {
            $birthday = new \DateTime('2000-01-01');
            $rows[] = [
                'Driver ' . $i,
                'birthday' => $birthday
                    ->sub(new DateInterval(sprintf("P%dD", $i)))
                    ->sub(new DateInterval(sprintf("P%dY", ($i % 20))))
                    ->format("Y-m-d"),
            ];
        }

        $this->batchInsert($this->table, [
            'name',
            'birthday',
        ], $rows);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }

}
