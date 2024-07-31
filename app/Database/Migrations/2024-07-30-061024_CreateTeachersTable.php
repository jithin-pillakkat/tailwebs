<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateTeachersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 200
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP')
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'default' => null,
                'on update' => 'CURRENT_TIMESTAMP'
            ]
        ]);

        $this->forge->addKey('id', true);

        $this->forge->createTable('teachers');
    }

    public function down()
    {
        $this->forge->dropTable('teachers');
    }
}
