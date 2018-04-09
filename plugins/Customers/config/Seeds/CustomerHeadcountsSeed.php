<?php
use Migrations\AbstractSeed;

/**
 * CustomerHeadcounts seed.
 */
class CustomerHeadcountsSeed extends AbstractSeed
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
          'name' => '5 a 15 empleados',
        ],
        [
          'name' => '16 a 50 empleados',
        ],
        [
          'name' => '51 a 100 empleados',
        ],
        [
          'name' => '101 a 500 empleados',
        ],
        [
          'name' => 'Más de 500 empleados',
        ],
      ];
        $table = $this->table('customer_headcounts');
        $table->insert($data)->save();
    }
}
