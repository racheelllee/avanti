<?php
use Migrations\AbstractSeed;

/**
 * CustomerStatus seed.
 */
class CustomerStatusSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run()
    {
      $data = [
        [
          'name' => 'Activo',
          'label' => 'activo',
          'color' => '#04b78e',
        ],
        [
          'name' => 'Inactivo',
          'label' => 'inactivo',
          'color' => '#969696',
        ],
      ];

        $table = $this->table('customer_statuses');
        $table->insert($data)->save();
    }
}
