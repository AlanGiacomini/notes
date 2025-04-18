<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Services\Operations;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MainController extends Controller
{
   public function index(){
      //load user's notes
      $id = session('user.id');
      $notes = User::find($id)
      ->notes()
      ->whereNull('deleted_at')
      ->orderBy('created_at', 'desc')
      ->get()
      ->toArray();
      
      $notes = array_map(function ($note) {
         $note['created_at'] = Carbon::parse($note['created_at'])->format('d/m/Y H:i:s');
         $note['updated_at'] = Carbon::parse($note['updated_at'])->format('d/m/Y H:i:s');
         return $note;
      }, $notes);

      //show home view
      return view('home', [
         'username' => session('user.username'),
         'notes' => $notes
      ]);
   }

   public function newNote(){
      //show new note view
      return view('new_note', [
         'username' => session('user.username'),
      ]);
   }

   public function insertNote(Request $request){

       //FORM VALIDATION
       $request->validate(
         //      validation rules
         [
             'text_title' => 'required|min:3|max:200',
             'text_note' => 'required|min:3|max:3000',
         ],
         //      error messages
         [
             'text_title.required' => 'O título não pode ficar vazio',
             'text_title.min' => 'O título deve ter pelo menos :min caracteres',
             'text_title.max' => 'O título deve ter no máximo :max caracteres',
             'text_note.required' => 'O texto da nota não pode ficar vazio',
             'text_note.min' => 'O texto deve ter pelo menos :min caracteres',
             'text_note.max' => 'O texto deve ter no máximo :max caracteres',
             ]
     );

      //GET USER INPUT
      $title = $request->input('text_title');
      $note = $request->input('text_note');

      //GET USER ID
      $id = session('user.id');

      //CREATE NEW NOTE
      $note = new Note();
      $note->user_id = $id;
      $note->title = $request->text_title;
      $note->text = $request->text_note;
      $note->save();

      //REDIRECT TO HOME
      return redirect()->route('home');

      echo 'Inserindo nova nota "'.$note. '"  com título "'.$title.'"';
   }

   public function editNote($id){
      $id = Operations::decryptValue($id);

      //LOAD NOTE
      $note = Note::find($id);

      //show edit note view
      return view('edit_note', [
         'note' => $note,
         'username' => session('user.username')
      ]) ;
   }

   public function updateNote(Request $request){
      //FORM VALIDATION
      $request->validate(
         //      validation rules
         [
            'text_title' => 'required|min:3|max:200',
            'text_note' => 'required|min:3|max:3000',
         ],
         //      error messages
         [
            'text_title.required' => 'O título não pode ficar vazio',
            'text_title.min' => 'O título deve ter pelo menos :min caracteres',
            'text_title.max' => 'O título deve ter no máximo :max caracteres',
            'text_note.required' => 'O texto da nota não pode ficar vazio',
            'text_note.min' => 'O texto deve ter pelo menos :min caracteres',
            'text_note.max' => 'O texto deve ter no máximo :max caracteres',
            ]
      );

      //check if note id exists
      if($request->note_id == null){
         return redirect()->route('home');
      }

      //decrypt note_id
      $id = Operations::decryptValue($request->note_id);

      //load note
      $note = Note::find($id);

      //update note
      $note->title = $request->text_title;
      $note->text = $request->text_note;
      $note->save();

      //REDIRECT TO HOME
      return redirect()->route('home');
   }

   public function removeNote($id){
      $id = Operations::decryptValue($id);

      //load note
      $note = Note::find($id);

      $viewDados = [
         'note'=>$note,
         'username' => session('user.username')
      ];

      //show delete note confirmation
      return view('delete_note', $viewDados);
   }

   public function deleteNote($id){
      $id = Operations::decryptValue($id);

      //load note
      $note = Note::find($id);

      //1 - Hard delete note | property disabled in model
      //$note->delete();

      //2 - Soft delete note | made manual without the property
      // $note->deleted_at = date('Y:m:d H:i:s');
      // $note->save();

      //3 - Soft delete note | property enabled in model
      $note->delete();

       //REDIRECT TO HOME
       return redirect()->route('home');
   }

   /**
    * TRY CATCH PARA DECRIPTAR O ID VINDO NO GET (desativado, pois fiz um Service para essa função)
    * @param mixed $id
    */
   // private function decryptId($id){
   //    //check if the id is encrypted
   //    try {
   //       $id = Crypt::decrypt($id);
   //    }
   //    //DECRYPT EXCEPTION PEGA O ERRO DO DECRIPTADOR
   //    catch (DecryptException $e) {
   //       return redirect()->route('home');
   //    }
   //    return $id;
   // }
}

/*
Aqui está a estrutura de pastas completa, integrando views e components, com base no Atomic Design. Essa organização separa átomos e moléculas como componentes Blade e organismos, templates e páginas como views.
Estrutura Final de Pastas:
resources/
├── views/
│   ├── components/                # Componentes reutilizáveis
│   │   ├── atom/                 # Átomos
│   │   │   ├── button.blade.php   # Botões
│   │   │   ├── input.blade.php    # Campos de entrada
│   │   │   ├── icon.blade.php     # Ícones
│   │   ├── molecule/             # Moléculas
│   │   │   ├── card.blade.php     # Cartões
│   │   │   ├── modal.blade.php    # Modais
│   │   │   ├── form.blade.php     # Pequenos formulários
│   ├── organism/                 # Organismos maiores
│   │   ├── header.blade.php       # Cabeçalho
│   │   ├── footer.blade.php       # Rodapé
│   │   ├── sidebar.blade.php      # Barra lateral
│   ├── template/                 # Templates reutilizáveis
│   │   ├── main.blade.php         # Layout principal
│   │   ├── busca.blade.php        # Página de busca
│   │   ├── tabela.blade.php       # Página com tabelas
│   │   ├── configuracao.blade.php # Layout para configurações
│   ├── page/                     # Páginas específicas
│   │   ├── index.blade.php        # Página inicial
│   │   ├── contato.blade.php      # Página "Fale Conosco"
│   │   ├── usuarios.blade.php     # Lista de usuários
*/