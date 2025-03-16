<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MainController extends Controller
{
   public function index(){
      //load user's notes
      $id = session('user.id');
      $user = User::find($id)->toArray();
      $notes = User::find($id)->notes()->get()->toArray();

      //   echo '<pre>';
      //   print_r($notes);
      //   echo '<pre>';

      //show home view
      return view('home', [
         'username' => $user['username'],
         'notes' => $notes
      ]);
   }

   public function newNote(){
      echo 'im creating a new note';
   }
}
