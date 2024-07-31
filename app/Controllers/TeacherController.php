<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\CIAuth;
use App\Models\Teacher;
use CodeIgniter\HTTP\ResponseInterface;

class TeacherController extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function loginHandler()
    {
        if ($this->request->isAJAX()) {

            $validate = [
                'username' => [
                    'rules' => 'required|max_length[100]|min_length[3]'
                ],
                'password' => [
                    'rules' => 'required|max_length[100]|min_length[8]'
                ]
            ];

            if (!$this->validate($validate)) {
                return response()->setJSON([
                    'token' => csrf_hash(),
                    'errors' => $this->validator->getErrors()
                ]);
            } else {

                $teacher = new Teacher();
                $exist = $teacher->asObject()->where('username', $this->request->getPost('username'))->first();
                if ($exist) {

                    if (CIAuth::checkPassword($this->request->getPost('password'), $exist->password)) {

                        CIAuth::setUserData($exist);

                        return response()->setJSON([
                            'status' => true,
                            'token' => csrf_hash(),
                            'message' => 'Logged successfully.'
                        ]);

                    } else {

                        return response()->setJSON([
                            'status' => false,
                            'token' => csrf_hash(),
                            'message' => 'The password is wrong!'
                        ]);
                    }

                } else {
                    return response()->setJSON([
                        'status' => false,
                        'token' => csrf_hash(),
                        'message' => 'Invalid username!'
                    ]);
                }
            }


        }
    }

    public function logout(){
        CIAuth::logout();
        return redirect()->route('login');
    }
}
