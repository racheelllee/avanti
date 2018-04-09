<?php
use Migrations\AbstractMigration;

class Customers extends AbstractMigration
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
        $table = $this->table('customers');
        $table->addColumn('title', 'string', [
            'default' => '',
            'limit' => 256,
            'null' => false,
        ]);
        $table->addColumn('business_name', 'string', [
            'default' => '',
            'limit' => 256,
            'null' => false,
        ]);
        $table->addColumn('street', 'string', [
            'default' => '',
            'limit' => 256,
            'null' => false,
        ]);
        $table->addColumn('number', 'string', [
            'default' => '',
            'limit' => 64,
            'null' => false,
        ]);
        $table->addColumn('municipality', 'string', [
            'default' => '',
            'limit' => 256,
            'null' => false,
        ]);
        $table->addColumn('state', 'string', [
            'default' => '',
            'limit' => 256,
            'null' => false,
        ]);
        $table->addColumn('country', 'string', [
            'default' => '',
            'limit' => 256,
            'null' => false,
        ]);
        $table->addColumn('postal_code', 'integer', [
            'default' => 0,
            'limit' => 8,
            'null' => false,
        ]);
        $table->addColumn('customer_category_id', 'integer', [
            'default' => 0,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('office_id', 'integer', [
            'default' => 0,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('customer_type_id', 'integer', [
            'default' => 0,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('customer_headcount_id', 'integer', [
            'default' => 0,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('website', 'string', [
            'default' => '',
            'limit' => 512,
            'null' => false,
        ]);
        $table->addColumn('customer_since', 'date', [
            'default' => null,
            'null' => true,
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
      $this->dropTable('customers');
    }

}
