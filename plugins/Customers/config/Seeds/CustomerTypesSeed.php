<?php
use Migrations\AbstractSeed;

/**
 * CustomerTypes seed.
 */
class CustomerTypesSeed extends AbstractSeed
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
          'name' => 'Tipo Uno',
          'label' => 'tipo_uno',
        ],
        [
          'name' => 'Tipo Dos',
          'label' => 'tipo_dos',
        ],
      ];

      $table = $this->table('customer_types');
      $table->insert($data)->save();
    }
}
