<?php
use Migrations\AbstractMigration;

class AddSecondEmailToContacts extends AbstractMigration
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
        $table->addColumn('second_email', 'string', [
            'default' => '',
            'limit' => 256,
            'null' => false,
        ]);
        $table->update();
    }
}
