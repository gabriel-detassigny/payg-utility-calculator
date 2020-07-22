<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddReadings extends AbstractMigration
{
    public function change(): void
    {
        $this->table('readings')
            ->addColumn('topUp', 'float')
            ->addColumn('amount', 'float')
            ->addColumn('added', 'datetime')
            ->addColumn('utility_id', 'integer')
            ->addForeignKey('utility_id', 'utilities')
            ->create();
    }
}
