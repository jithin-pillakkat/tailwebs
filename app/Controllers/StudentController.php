<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Student;
use CodeIgniter\HTTP\ResponseInterface;

class StudentController extends BaseController
{
    public function index()
    {
        return view('student/index');
    }

    public function list()
    {

        $column = array("id", "name", "subject", "mark");

        $query = "SELECT * FROM students";

        if (isset($_GET["search"]["value"])) {
            $query .= ' WHERE name LIKE "%' . $_GET["search"]["value"] . '%" 
                        OR subject LIKE "%' . $_GET["search"]["value"] . '%" 
                        OR mark LIKE "%' . $_GET["search"]["value"] . '%" ';
        }

        if (isset($_GET["order"])) {
            $query .= 'ORDER BY ' . $column[$_GET['order']['0']['column']] . ' ' . $_GET['order']['0']['dir'] . ' ';
        } else {
            $query .= 'ORDER BY id DESC ';
        }

        $query1 = '';

        if ($_GET["length"] != -1) {
            $query1 = 'LIMIT ' . $_GET['start'] . ', ' . $_GET['length'];
        }

        $db = db_connect();
        $student = $db->query($query);

        $number_filter_row = $student->getNumRows();

        $statement = $db->query($query . $query1);

        $result = $statement->getResultArray();

        $data = array();

        foreach ($result as $row) {
            $sub_array = array();
            $sub_array[] = $row['id'];
            $sub_array[] = $row['name'];
            $sub_array[] = $row['subject'];
            $sub_array[] = $row['mark'];
            $data[] = $sub_array;
        }


        $numRows = $db->table('students')->countAll();

        $output = array(
            'draw' => intval($_GET['draw']),
            'recordsTotal' => $numRows,
            'recordsFiltered' => $number_filter_row,
            'data' => $data
        );

        echo json_encode($output);
    }


    public function save()
    {

        if ($this->request->isAJAX()) {

            $validate = [
                'name' => [
                    'rules' => 'required|min_length[3]|max_length[100]',
                ],
                'subject' => [
                    'rules' => 'required|min_length[3]|max_length[100]',
                ],
                'mark' => [
                    'rules' => 'required|integer'
                ]
            ];

            if (!$this->validate($validate)) {
                return response()->setJSON([
                    'token' => csrf_hash(),
                    'errors' => $this->validator->getErrors()
                ]);
            } else {

                $student = new Student();
                $exist = $student->asObject()->where(['name' => $this->request->getPost('name'), 'subject' => $this->request->getPost('subject')])->first();

                if ($exist) {

                    $student->where('id', $exist->id)->set(['mark' => $this->request->getPost('mark')])->update();
                    return response()->setJSON([
                        'status' => true,
                        'token' => csrf_hash(),
                        'message' => 'Student mark updated successfully.'
                    ]);

                } else {

                    $studentData = [
                        'name' => ucfirst($this->request->getPost('name')),
                        'subject' => ucfirst($this->request->getPost('subject')),
                        'mark' => $this->request->getPost('mark')
                    ];
                    $student->insert($studentData);
                    return response()->setJSON([
                        'status' => true,
                        'token' => csrf_hash(),
                        'message' => 'New student added successfully.'
                    ]);
                }
            }
        }
    }


    public function action()
    {

        if ($this->request->getPost('action') == 'edit') {

            $student = new Student();
            $student->where('id', $this->request->getPost('id'))
                ->set([
                    'name' => $this->request->getPost('name'),
                    'subject' => $this->request->getPost('subject'),
                    'mark' => $this->request->getPost('mark')
                ])
                ->update();

            echo json_encode($this->request->getPost());
        }

        if ($this->request->getPost('action') == 'delete') {
            $student = new Student();
            $student->where('id', $this->request->getPost('id'))->delete();

            echo json_encode($this->request->getPost());
        }
    }


    public function normalTable()
    {
        $student = new Student();
        $data['students'] = $student->asObject()->orderBy('id', 'DESC')->findAll();
        return view('student/normal', $data);
    }

    public function normalTableAction()
    {

        if ($this->request->isAJAX()) {

            if ($this->request->getPost('action') == 'edit') {

                $validate = [
                    'name' => [
                        'rules' => 'required|min_length[3]|max_length[100]',
                    ],
                    'subject' => [
                        'rules' => 'required|min_length[3]|max_length[100]',
                    ],
                    'marks' => [
                        'rules' => 'required|integer'
                    ]
                ];

                if (!$this->validate($validate)) {
                    return response()->setJSON([
                        'newToken' => csrf_hash(),
                        'errors' => $this->validator->getErrors()
                    ]);
                } else {

                    $student = new Student();
                    $student->where('id', $this->request->getPost('id'))
                        ->set([
                            'name' => $this->request->getPost('name'),
                            'subject' => $this->request->getPost('subject'),
                            'mark' => $this->request->getPost('marks')
                        ])
                        ->update();

                    return response()->setJSON([
                        'status' => true,
                        'newToken' => csrf_hash(),
                        'message' => 'Student details updated successfully.',
                        'data' => $this->request->getPost()
                    ]);
                }
            }


            if ($this->request->getPost('action') == 'delete') {
               
                $student = new Student();
                $student->where('id', $this->request->getPost('id'))->delete();
    
                return response()->setJSON([
                    'status' => true,
                    'newToken' => csrf_hash(),
                    'message' => 'Student data deleted successfully.',
                ]);
            }
        }
    }

}
