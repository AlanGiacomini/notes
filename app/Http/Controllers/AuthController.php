<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(){
        //COMANDO QUE CHAMA A VIEW LOGIN
        return view('login');
    }

    public function loginSubmit(Request $request){
        //O COMANDO ABAIXO FAZ O DUMP DA VARIÁVEL (APARECE FORMATADO ATÉ)
        //dd($request);

        //FORM VALIDATION
        $request->validate(
            //      validation rules
            [
                /*NÃO PRECISA FICAR COLOCANDO CADA REGRA EM UMA LINHA
                AS OUTRAS REGRAS DE VALIDAÇÃO PODEM SER SEPARADAS POR PIPE (REGRA1|REGRA2) 
                OU COLOCADAS DENTRO DE UM ARRAY ([REGRA1,REGRA2])*/
                'text_username' => 'required|email',
                'text_password' => 'required|min:6|max:16',
            ],
            //      error messages
            [
                'text_username.required' => 'O usuário é obrigatório',
                'text_username.email' => 'O usuário deve ser um e-mail',
                'text_password.required' => 'A senha é obrigatória',
                'text_password.min' => 'A senha deve ter pelo menos :min caracteres',
                'text_password.max' => 'A senha deve ter no máximo :max caracteres',
                ]
        );

        //GET USER INPUT
        $username = $request->input('text_username');
        $password = $request->input('text_password');

        //TESTANDO CONEXÃO COM BASE DE DADOS
        /* try {
            DB::connection()->getPdo();
            echo 'Connection is OK!';
        } catch (\PDOException $e) {
            echo 'Connection failed: '.$e->getMessage();
        } */

        //get all users from the database (método 1)
        /* $users = User::all()->toArray(); */

        //get all users from the database (método 2 - objeto)
        /* $userModel = new User();
        $users = $userModel->all()->toArray(); */

        //check if user existis
        $user = User
        ::where('username', $username)
        ->where('deleted_at', NULL)
        ->first();

        if(!$user){
            return redirect()
            ->back()
            ->withInput()
            ->with('loginError', 'Username ou senha incorretos');
        }

        //check if password is correct
        if(!password_verify($password, $user->password)){
            return redirect()
            ->back()
            ->withInput()
            ->with('loginError', 'Username ou senha incorretos');
        };

        //update last login
        $user->last_login = date('Y-m-d H:i:s');
        $user->save();

        //login user (insert logged user in a session)
        session([
            'user' =>[
                'id' => $user->id,
                'username' => $user->username
            ]
        ]);

        return redirect('/');
    }

    public function logout(){
        //logout from aplication
        session()->forget('user');
        return redirect()->to('/login');
    }
}
