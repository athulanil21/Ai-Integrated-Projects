<?php

namespace App\Controllers;
use App\Models\UserModel;

class Home extends BaseController
{
    public function __construct()
    {
        helper(['url']);
        $this->user = new UserModel();
    }
    public function index(): string
    {
        $data['users'] = $this->user->orderby('id','DESC')->paginate(3,'group1');
        $data['pager'] = $this->user->pager;
        return view('/inc/header') . view('home', $data) . view('/inc/footer');
    }
    public function saveUser()
    {
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');

        $this->user->insert([
            'username' => $username,
            'email' => $email
        ]);

        session()->setFlashdata('success', 'data inserted successfully');
        return redirect()->to(base_url());
    }

    public function getSingleUser($id)
    {
        $data = $this->user->find($id);
        return $this->response->setJSON($user);
    }
}
