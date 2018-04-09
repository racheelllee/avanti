<?php
use Migrations\AbstractMigration;

class RemoveDepartmentFromContacts extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('contacts');
        $table->removeColumn('department');
        $table->removeColumn('street');
        $table->removeColumn('number');
        $table->removeColumn('colony');
        $table->removeColumn('municipality');
        $table->removeColumn('postal_code');
        $table->update();
    }
}
