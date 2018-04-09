<?php
use Migrations\AbstractMigration;

class CustomerHeadcounts extends AbstractMigration
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
        $table = $this->table('customer_headcounts');
        $table->addColumn('name', 'string', [
            'default' => '',
            'limit' => 256,
            'null' => false,
        ]);
        $table->create();
    }

    public function down(){
      $this->dropTable('customer_headcounts');
    }

}
