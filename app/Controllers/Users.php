<?php

namespace App\Controllers;

class Users extends BaseController
{
    public function index(): string
    {
        return view('register');
    }
    public function create()
    {
        $rules =[
            'user' => 'required|max_length[30]|is_unique[users.user]',
            'password' => 'required|max_length[50]|min_length[5]',
            'repassword' => 'matches[password]',
            'name' => 'required|max_length[100]',
            'email' => 'required|max_length[80]|valid_email|is_unique[user.email]'

        ];
        if(!$this->validate($rules)){
            return redirect()->back()->withInput()->with('errors', $this->validator->listErrors());
        }
    }
}
