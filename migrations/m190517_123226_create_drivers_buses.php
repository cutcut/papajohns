<?php

use yii\db\Migration;

/**
 * Class m190516_123226_create_drivers_buses
 */
class m190517_123226_create_drivers_buses extends Migration
{
    private $table = 'drivers_buses';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'driver_id' => $this->integer()->notNull(),
            'bus_id' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('driver_bus', $this->table, ['driver_id', 'bus_id']);

        $this->execute(sprintf(
            "INSERT INTO `%s` (`driver_id`, `bus_id`)
            SELECT drivers.id , buses.id FROM drivers JOIN buses ON drivers.id %% buses.id = 0",
            $this->table
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }

}
