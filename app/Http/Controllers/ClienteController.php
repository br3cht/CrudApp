<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\datasec;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
  public function index(){
    $clientes = Cliente::all()->toArray();
    return array_reverse($clientes);

  }

  public function show($id){
    $clientes = Cliente::where('id', $id)->first();
    return response()->json($aluno);
  }

  public function store(Request $request){
    function save_db($request){
      $cliente = new Cliente();
      $cliente->nome = strtoupper($request->nome);
      $cliente->sobrenome = strtoupper($request->sobrenome);
      $cliente->cidade = $request->cidade;
      $cliente->email = $request->email;
      $cliente->UF = $request->uf;
      $cliente->telefone = $request->telefone;
      $cliente->endereco = $request->endereco;
      $cliente->sexo = $request->sexo[0];
      $cliente->datanascimento = $request->datanascimento;

      $cliente->save();

      $sensitive_data = new datasec();
      $sensitive_data->cpf = $request->cpf;
      $cliente->datasecs()->save($sensitive_data);
    }

    $validator = Validator::make($request->all(), [
          'email'=>'required|unique:clientes',
          'telefone'=>'required|unique:clientes',
          'cpf'=>'required|unique:datasecs',
        ],['email.unique'=>'email já cadastrado','cpf.unique'=>'cpf já cadastrado','telefone.unique'=>'telefone já cadastrado']);

    if($validator->passes()){
       save_db($request);
       return ['sucess'=>1];
     }

    if($validator->fails()){
      return ['sucess'=>0,'message'=>$validator->errors()];
    }

  }
}
