<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTables extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $tablePessoa = $this->table('pessoas');
        $tablePessoa->addColumn('nome', 'string', ['limit' => 255])
            ->create();
        $tableUnidade = $this->table('unidades');
        $tableUnidade->addColumn('nome', 'string', ['limit' => 255])
            ->create();
        $tableProcessos = $this->table('processos');
        $tableProcessos->addColumn('nome', 'string', ['limit' => 255])
            ->addColumn('status', 'integer')
            ->addColumn('data_criacao', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('data_modificacao', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('id_volk', 'integer')
            ->addColumn('pessoa_id', 'integer', ['signed' => false])
            ->addColumn('unidade_id', 'integer', ['signed' => false])
            ->addForeignKey(['pessoa_id'], 'pessoas')
            ->addForeignKey(['unidade_id'], 'unidades')
            ->create();
    }
}