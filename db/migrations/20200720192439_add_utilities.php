<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddUtilities extends AbstractMigration
{
    public function change(): void
    {
        $utilities = $this->table('utilities');
        $utilities->addColumn('name', 'string', ['limit' => 50])
            ->addIndex(['name'], ['unique' => true])
            ->create();
    }
}
