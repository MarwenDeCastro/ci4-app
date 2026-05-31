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

    // =========================
    // DISPLAY USERS
    // =========================
    public function index()
    {
        $search = $this->request->getGet('search');

        $query = $this->userModel;

        // Search Function
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

    // =========================
    // UPLOAD USER
    // =========================
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

        // Validate Form
        if (!$this->validate($validationRule)) {

            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Get Uploaded File
        $img = $this->request->getFile('avatar');

        // Check Upload
        if ($img->isValid() && !$img->hasMoved()) {

            // Generate Random File Name
            $newName = $img->getRandomName();

            // Move File
            $img->move(ROOTPATH . 'public/uploads/', $newName);

            // Save Data
            $userData = [

                'name' => $this->request->getPost('name'),

                'email' => $this->request->getPost('email'),

                'avatar' => 'uploads/' . $newName
            ];

            // Insert Data
            $this->userModel->save($userData);

            return redirect()->to('/users')
                ->with('success', 'User created successfully!');
        }

        return redirect()->back()
            ->with('error', 'File upload failed.');
    }

    // =========================
    // DELETE USER
    // =========================
    public function delete($id)
    {
        // Find User
        $user = $this->userModel->find($id);

        // Check If User Exists
        if (!$user) {

            return redirect()->to('/users')
                ->with('error', 'User not found.');
        }

        // Delete Avatar Image
        if (!empty($user['avatar'])) {

            $filePath = ROOTPATH . 'public/' . $user['avatar'];

            if (file_exists($filePath)) {

                unlink($filePath);
            }
        }

        // Delete User Record
        $this->userModel->delete($id);

        return redirect()->to('/users')
            ->with('success', 'User deleted successfully!');
    }
}