<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
   public function index(){
     $user = User::where('is_super_user', 0)->get();
     return response()->json($user);
   }

   public function show($filtro){
     // $user = User::find($filtro);
     // $user->tokens()->delete();
     return response()->json('aaaaaaaaa');
   }

   public function update($id, Request $request){
     $user = User::find($id);
     $user->update($request->all());

     return ['status'=>'sucess','msg'=>'Usuario Atualizado com Sucesso'];
   }

   public function store(Request $request){
     function save_user($request){
       $user = User::create([
         'name'=>$request->name,
         'email'=>$request->email,
         'password'=>Hash::make($request->password),
       ]);
     }

      $validator = Validator::make($request->all(),[
        'name'=>'required',
        'email'=>'required|email|unique:users',
        'password'=>'required|min:6|confirmed',
        'password_confirmation'=>'required',

      ],['email.unique'=>'Email Cadastrado']);

      if($validator->passes()){
        save_user($request);
        return ['status'=>true];
      }
     return ['status'=>false,'message'=>$validator->errors()];
   }

   public function destroy($id){
     function revoke_all_tokens($user){
       $user->tokens()->delete();
     }

     $user = User::find($id);
     revoke_all_tokens($user);
     $user->delete();
     return response()->json('Usuario Deletado');
     // $user->delete();
   }

}
