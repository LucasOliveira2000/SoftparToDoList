<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\tarefa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TarefaController extends Controller
{

    public function index()
    {
        $tarefas = tarefa::where('user_id', Auth::user()->id)
        ->paginate(6)
        ->through( function($tarefa){

            if($tarefa->status == 1){
                $nomeStatus = "Pendente";
            }elseif($tarefa->status == 2){
                $nomeStatus = "Em andamento";
            }elseif($tarefa->status == 3){
                $nomeStatus = "Concluída";
            }else{
                $nomeStatus = "Indefinido";
            }

            return [
                "id" => $tarefa->id,
                "titulo" => $tarefa->titulo,
                "categoria" => $tarefa->categoria->nome ?? "Sem categoria",
                "status" => $nomeStatus,
                "descricao" => $tarefa->descricao,
                "ativo" => $tarefa->ativo,
                'data_conclusao' => $tarefa->data_conclusao ? $tarefa->data_conclusao->format("d/m/Y") : "Sem Data",
                "created_at" => $tarefa->created_at->format("d/m/Y")
            ];
        });

        return Inertia::render('Tarefa/Index',[
            "tarefas" => $tarefas,
            "flash" => session()->get('flash', [])
        ]);
    }

    public function create()
    {
        $categorias = Categoria::where('user_id', Auth::user()->id)->where("ativo",1)->get();

        $status = [
            ["id" => 1, "nome" => "Pendente"],
            ["id" => 2, "nome" => "Em andamento"],
            ["id" => 3, "nome" => "Concluída"],
        ];

        return Inertia::render('Tarefa/Create',[
            "categorias" => $categorias,
            "titulo" => "",
            "descricao" => "",
            "status" => $status,
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'categoria_id' => 'required',
            'titulo' => 'required',
            'descricao' => 'required',
            'status' => 'required',
        ],[
            'categoria_id.required' => 'Selecione uma categoria',
            'titulo.required' => 'Informe o título da tarefa',
            'status.required' => 'Selecione o status da tarefa',
            'descricao.required' => 'Informe a descrição da tarefa',
        ]);

        $tarefa = tarefa::create([
            'user_id' => Auth::user()->id,
            'categoria_id' => $request->categoria_id,
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'status' => $request->status,
            'ativo' => 1,
        ]);

        return to_route('tarefa.index')->with('sucesso', 'Tarefa '.$tarefa->titulo.' criada com sucesso!');
    }

    public function edit($id)
    {
        $tarefa = Tarefa::findOrFail($id);
        $categorias = Categoria::all(['id', 'nome']); // Retorna 'id' e 'nome' para as categorias
        $status = [
            ["id" => 1, "nome" => "Pendente"],
            ["id" => 2, "nome" => "Em andamento"],
            ["id" => 3, "nome" => "Concluída"],
        ];

        return Inertia::render('Tarefa/Edit', [
            "tarefa" => $tarefa,
            "categorias" => $categorias,
            "status" => $status,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'titulo' => 'required',
            'descricao' => 'required',
            'status' => 'required|in:1,2,3',
        ],[
            'categoria_id.required' => 'Selecione uma categoria',
            'categoria_id.exists' => 'Categoria não encontrada',
            'titulo.required' => 'Informe o título da tarefa',
            'descricao.required' => 'Informe a descrição da tarefa',
            'status.required'   => 'Selecione o status da tarefa',
        ]);

        $tarefa = Tarefa::find($id);

        $tarefa->update([
            'categoria_id' => $request->categoria_id,
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'status' => $request->status,
        ]);

        return to_route('tarefa.index')->with('sucesso', 'Tarefa '.$tarefa->titulo.' atualizada com sucesso!');
    }

    public function avancaStatus($id)
    {
        $tarefa = Tarefa::find($id);

        if($tarefa->status == 3){
            return to_route('tarefa.index')->with('erro', 'Tarefa '.$tarefa->titulo.' já está concluída!');
        }

        if($tarefa->status == 2){
            $tarefa->update([
                'status' => $tarefa->status + 1,
                'data_conclusao' => date('Y-m-d H:i:s'),
            ]);
        }else{
            $tarefa->update([
                'status' => $tarefa->status + 1,
            ]);
        }


        return to_route('tarefa.index')->with('sucesso', 'Tarefa '.$tarefa->titulo.' avançou de status!');
    }

    public function ativa($id)
    {
        $tarefa = Tarefa::find($id);

        $tarefa->update([
            'ativo' => 1,
        ]);

        return to_route('tarefa.index')->with('sucesso', 'Tarefa '.$tarefa->titulo.' ativada com sucesso!');
    }

    public function desativa($id)
    {
        $tarefa = Tarefa::find($id);

        $tarefa->update([
            'ativo' => 0,
        ]);

        return to_route('tarefa.index')->with('sucesso', 'Tarefa '.$tarefa->titulo.' desativada com sucesso!');
    }

    public function destroy($id)
    {
        $tarefa = Tarefa::find($id);

        if($tarefa->status == 3){
            return to_route('tarefa.index')->with('erro', 'Tarefa '.$tarefa->titulo.' não pode ser excluída pois está concluída!');
        }elseif($tarefa){
            $tarefa->delete();
        }

        return to_route('tarefa.index')->with('sucesso', 'Tarefa '.$tarefa->titulo.' excluída com sucesso!');

    }
}
