<?php
use Migrations\AbstractMigration;

class Contacts extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function up()
    {
        $table = $this->table('contacts');
        $table->addColumn('customer_id', 'integer', [
            'default' => 0,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('first_name', 'string', [
            'default' => '',
            'limit' => 256,
            'null' => false,
        ]);
        $table->addColumn('middle_name', 'string', [
            'default' => '',
            'limit' => 256,
            'null' => false,
        ]);
        $table->addColumn('last_name', 'string', [
            'default' => '',
            'limit' => 256,
            'null' => false,
        ]);
        $table->addColumn('department', 'string', [
            'default' => '',
            'limit' => 128,
            'null' => false,
        ]);
        $table->addColumn('email', 'string', [
            'default' => '',
            'limit' => 128,
            'null' => false,
        ]);
        $table->addColumn('phone', 'string', [
            'default' => '',
            'limit' => 24,
            'null' => false,
        ]);
        $table->addColumn('phone_ext', 'string', [
            'default' => '',
            'limit' => 8,
            'null' => false,
        ]);
        $table->addColumn('mobile_phone', 'string', [
            'default' => '',
            'limit' => 24,
            'null' => false,
        ]);
        $table->addColumn('street', 'string', [
            'default' => '',
            'limit' => 128,
            'null' => false,
        ]);
        $table->addColumn('number', 'string', [
            'default' => '',
            'limit' => 8,
            'null' => false,
        ]);
        $table->addColumn('colony', 'string', [
            'default' => '',
            'limit' => 128,
            'null' => false,
        ]);
        $table->addColumn('municipality', 'string', [
            'default' => '',
            'limit' => 128,
            'null' => false,
        ]);
        $table->addColumn('country', 'string', [
            'default' => '',
            'limit' => 128,
            'null' => false,
        ]);
        $table->addColumn('postal_code', 'string', [
            'default' => '',
            'limit' => 8,
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('deleted', 'integer', [
            'default' => 0,
            'limit' => 1,
            'null' => false,
        ]);
        $table->create();
    }

    public function down(){
      $this->dropTable('contacts');
    }

}
