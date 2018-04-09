<?php
use Migrations\AbstractSeed;
require_once 'vendor/fzaninotto/faker/src/autoload.php';
/**
 * Customers seed.
 */
class CustomersSeed extends AbstractSeed
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
        $faker = Faker\Factory::create();
        for ($i=0; $i < 100; $i++) {
            $data[] = [
                'title'             => $faker->jobTitle,
                'first_name'        => $faker->name,
                'last_name'         => $faker->lastName,
                'RFC'               => $faker->ean13,
                'user_id'           => rand(1, 10),
                'customer_type_id'  => rand(1, 3),
            ];
        }
        $table = $this->table('customers');
        $table->insert($data)->save();
    }
}
