<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Users extends BaseController
{
    protected $helpers = ['form'];
    
    public function index()//: string
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
            'email' => 'required|max_length[80]|valid_email|is_unique[users.email]'

        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->listErrors());
        }

        $userModel = new UsersModel();
        $post = $this->request->getPost(['user','password','name','email']);
        
        $token = bin2hex(random_bytes(20));
        $userModel->insert([
            'user' => $post ['user'],
            'password' => password_hash($post['password'],PASSWORD_DEFAULT),
            'name' => $post ['name'],
            'email' => $post ['email'],
            'active' => 0,
            'activation_token' => $token  
        ]);

        $email = \Config\Services::email();
        $email->setTo($post['email']);
        $email->setSubject('Activa tu cuenta');

        $url = base_url('active-user/' . $token);
        $body = '<p>Hola ' .$post['name'] . '</p>';
        $body .="<p>Para continuar con el proceso de registro, has clic en la siguiente liga <a href= '$url'>Active
        Cuenta</a></p>";
        $body .='Gracias!';

        $email->setMessage($body);
        $email->send();

        $title = 'Registro exitoso';
        $message = 'Revisa tu correo electronico para activar tu cuenta.';

        return $this->showMessage($title , $message);

    }

    private function showMessage($title , $message){
        $data = [ 
            'title' => $title,
            'message' => $message,
        ];
        return view('message' , $data);
    }
} 