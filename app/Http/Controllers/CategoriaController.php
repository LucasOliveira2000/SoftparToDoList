<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Tarefa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CategoriaController extends Controller
{

    public function index()
    {
        $categorias = Categoria::where('user_id', Auth::user()->id)
        ->paginate(6)
        ->through( function($categoria){
            return [
                "id" => $categoria->id,
                "nome" => $categoria->nome,
                "cor" => $categoria->cor,
                "ativo" => $categoria->ativo,
                'flash' => session()->all(),
                "created_at" => $categoria->created_at->format("d/m/Y"),

            ];
        });

        return Inertia::render("Categoria/Index",[
            "categorias" => $categorias

        ]);
    }

    public function create()
    {
        return Inertia::render("Categoria/Create",[
            "mome" => "",
            "cor" => ""
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome'      => 'required',
            'cor'       => 'nullable',
        ]);

        $categoria = Categoria::create([
            'nome'      => $request->nome,
            'user_id'   => Auth::user()->id,
            'cor'       => $request->cor,
            'ativo'     => 1,
        ]);

        return to_route('categoria.index')->with('sucesso', 'Categoria '.$categoria->nome.' criada com sucesso!');

    }

    public function ativa($id)
    {
        $categoria = Categoria::find($id);

        $categoria->update([
            'ativo' => 1,
        ]);

        return to_route('categoria.index')->with('sucesso', 'Categoria '.$categoria->nome.' ativada com sucesso!');
    }

    public function desativa($id)
    {
        $categoria = Categoria::find($id);

        $categoria->update([
            'ativo' => 0,
        ]);

        return to_route('categoria.index')->with('sucesso', 'Categoria '.$categoria->titulo.' desativada com sucesso!');
    }

    public function edit($id)
    {
        $categoria = Categoria::where('user_id', Auth::user()->id)
        ->where("ativo",1)
        ->where("id",$id)
        ->first();

        return Inertia::render("Categoria/Edit",[
            "id" => $categoria->id,
            "nome" => $categoria->nome,
            "cor" => $categoria->cor
        ]);

    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'nome'      => 'required',
            'cor'       => 'nullable',
        ]);

        $categoria = Categoria::where('user_id', Auth::user()->id)
        ->where("ativo",1)
        ->where("id",$id)
        ->first();

        $categoria->update([
            'nome'      => $request->nome,
            'cor'       => $request->cor,
        ]);

        return to_route('categoria.index')->with('sucesso', 'Categoria '.$categoria->nome.' atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $categoria = Categoria::where('user_id', Auth::user()->id)
        ->where("id",$id)
        ->first();

        $tarefa = Tarefa::where('categoria_id', $categoria->id)->first();

        if($tarefa){
            return to_route('categoria.index')->with('erro', 'Categoria '.$categoria->nome.' não pode ser excluída, pois possui tarefas vinculadas!');
        }else{
            $categoria->delete();
            return to_route('categoria.index')->with('sucesso', 'Categoria '.$categoria->nome.' excluída com sucesso!');
        }


    }
}
