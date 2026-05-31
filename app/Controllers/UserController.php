<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class UserController extends Controller
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();

        helper(['form', 'url']);
    }

    public function index()
    {
        $search = $this->request->getGet('search');

        $query = $this->userModel;

        if (!empty($search)) {

            $query = $query->like('name', $search)
                           ->orLike('email', $search);
        }

        $data = [

            'users' => $query->paginate(5),

            'pager' => $this->userModel->pager,

            'search' => $search
        ];

        return view('user_profile', $data);
    }
    public function upload()
    {
        // Validation Rules
        $validationRule = [

            'avatar' => [

                'label' => 'Image File',

                'rules' => [

                    'uploaded[avatar]',

                    'is_image[avatar]',

                    'mime_in[avatar,image/jpg,image/jpeg,image/png,image/webp]',

                    'max_size[avatar,2048]',
                ],
            ],

            'name' => 'required|min_length[3]',

            'email' => 'required|valid_email|is_unique[users.email]'
        ];

        if (!$this->validate($validationRule)) {

            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $img = $this->request->getFile('avatar');

        if ($img->isValid() && !$img->hasMoved()) {

            $newName = $img->getRandomName();

            $img->move(ROOTPATH . 'public/uploads/', $newName);

            $userData = [

                'name' => $this->request->getPost('name'),

                'email' => $this->request->getPost('email'),

                'avatar' => 'uploads/' . $newName
            ];

            $this->userModel->save($userData);

            return redirect()->to('/users')
                ->with('success', 'User created successfully!');
        }

        return redirect()->back()
            ->with('error', 'File upload failed.');
    }

    public function delete($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {

            return redirect()->to('/users')
                ->with('error', 'User not found.');
        }
        if (!empty($user['avatar'])) {

            $filePath = ROOTPATH . 'public/' . $user['avatar'];

            if (file_exists($filePath)) {

                unlink($filePath);
            }
        }

        $this->userModel->delete($id);

        return redirect()->to('/users')
            ->with('success', 'User deleted successfully!');
    }
}