<?php
use Migrations\AbstractSeed;

/**
 * CustomerCategories seed.
 */
class CustomerCategoriesSeed extends AbstractSeed
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
          'name' => 'Categoria Uno',
          'label' => 'categoria_uno',
        ],
        [
          'name' => 'Categoria Dos',
          'label' => 'categoria_dos',
        ],
        [
          'name' => 'Categoria Tres',
          'label' => 'categoria_tres',
        ],
      ];

      $table = $this->table('customer_categories');
      $table->insert($data)->save();
    }
}
