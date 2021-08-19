<?php
namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Validator;

class AuthController extends Controller{

  public function login(Request $request){
     $request->validate([
      'email' => 'required|email',
      'password' => 'required',
      'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
      $error = ValidationException::withMessages([
          'status'=>'failed',
       ]);
       return response()->json($error->errors());
    }

    return ['status'=>'sucess','token'=>$user->createToken($request->device_name)->plainTextToken];

  }


  public function register(Request $request){
      $attr = $request->validate([
        'name' =>'required',
        'email'=>'required|email|unique:users',
        'password'=>'required|min:6|confirmed',
        'password_confirmation' =>'required',
        'is_super_user'=>'required'
      ]);

      $user = User::create([
         'name' => $attr['name'],
         'email' => $attr['email'],
         'is_super_user'=>$attr['is_super_user'],
         'password' => Hash::make($attr['password'])
     ]);

     return response()->json(['msg' => 'Registrado com sucesso']);
  }

  public function logout(Request $request){
       $request->user()->currentAccessToken()->delete();
       $user = User::find($request->user()->id);

       if(count($user->tokens) > 0)
        $user->tokens()->delete();

       // $request->user()->currentAccessToken()->delete();
       // $user = User::find($request->user()->id);
       // $user->tokens()->delete();
       return response()->json(['msg' => 'Logout Successfull']);
   }

}
