<?php
use Migrations\AbstractSeed;

/**
 * ContactTypes seed.
 */
class ContactTypesSeed extends AbstractSeed
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
            [
                'name' => 'Tipo Tres',
                'label' => 'tipo_tres',
            ],
        ];
        $table = $this->table('contact_types');
        $table->insert($data)->save();
    }
}
