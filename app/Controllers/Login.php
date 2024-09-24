<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Login extends BaseController
{
    public function index()//: string
    {
        return view('login');
    }
    public function auth(){
        $rules = [
            'user' => 'required',
            'password' => 'required',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->listErrors());
        }

        $userModel = new UseresModel();
        $post = $this->request->getPost(['user', 'password']);

        $user = ;
    }
}