<?php

namespace App\Database\Seeds;

use App\Models\Student;
use CodeIgniter\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run()
    {

        $studentData = [
            [
                'name' => 'Rahul',
                'subject' => 'English',
                'mark' => rand(1, 100),
            ],
            [
                'name' => 'David',
                'subject' => 'Physics',
                'mark' => rand(1, 100),
            ],
            [
                'name' => 'Aparna',
                'subject' => 'Maths',
                'mark' => rand(1, 100),
            ],
            [
                'name' => 'Dhruv',
                'subject' => 'Chemistry',
                'mark' => rand(1, 100),
            ],
            [
                'name' => 'Digil',
                'subject' => 'Biology',
                'mark' => rand(1, 100),
            ]
        ];


        $student = new Student();
        $first = $student->find();
        if (empty($first)) {
            $student->insertBatch($studentData);
        }

    }


}
