<?php

namespace App\Database\Seeds;

use App\Models\Teacher;
use CodeIgniter\Database\Seeder;

class TeacherSeeder extends Seeder
{
    public function run()
    {
        $teacher = new Teacher();
        $first = $teacher->find();
        if (empty($first)) {
            $data = [
                'name' => 'Teacher',
                'username' => 'teacher_1',
                'password' => password_hash('12345678', PASSWORD_DEFAULT)
            ];
            $teacher->insert($data);
        }
    }
}
