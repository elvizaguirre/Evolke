<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class InitialData extends AbstractMigration
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
        $rows = [
            [
                'id' => 1,
                'nome' => 'Nome 1'
            ],
            [
                'id' => 2,
                'nome' => 'Nome 2'
            ],
            [
                'id' => 3,
                'nome' => 'Nome 3'
            ]
        ];
        $tablePessoa->insert($rows)->saveData();

        $tableUnidade = $this->table('unidades');
        $rows2 = [
            [
                'id' => 1,
                'nome' => 'Unidade 1'
            ],
            [
                'id' => 2,
                'nome' => 'Unidade 2'
            ],
            [
                'id' => 3,
                'nome' => 'Unidade 3'
            ]
        ];
        $tableUnidade->insert($rows2)->saveData();

        $tableProcesso = $this->table('processos');
        $rows3 = [
            [
                'id' => 1,
                'nome' => 'Processo 1',
                'status' => 1,
                'data_criacao' => '2023-02-01 15:24:02',
                'data_modificacao' => '2023-02-01 15:24:02',
                'pessoa_id' => 1,
                'unidade_id' => 1
            ],
            [
                'id' => 2,
                'nome' => 'Processo 2',
                'status' => 1,
                'data_criacao' => '2023-02-01 15:24:02',
                'data_modificacao' => '2023-02-01 15:24:02',
                'pessoa_id' => 2,
                'unidade_id' => 2
            ],
            [
                'id' => 3,
                'nome' => 'Processo 3',
                'status' => 3,
                'data_criacao' => '2023-02-01 15:24:02',
                'data_modificacao' => '2023-02-01 15:24:02',
                'pessoa_id' => 3,
                'unidade_id' => 3
            ]
        ];
        $tableProcesso->insert($rows3)->saveData();
    }
}