<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Filme;

class FilmeController extends Controller
{
    public function index()
    {
        $filmes = Filme::all();
        return view("index", ["filmes" => $filmes, "busca" => null]);
    }

    public function create()
    {
        return view("create");
    }

    public function store(Request $request) {
        // Pegando apenas o Título e a Descrição do formulário
        $dados = $request->only(['titulo', 'descricao']);
        
        if ($request->hasFile("imagem")) {
            $pasta = public_path("images/filmes");
            if (!is_dir($pasta)) {
                mkdir($pasta, 0755, true);
            }

            $imagem = $request->file("imagem");
            $nomeImagem = time() . "_" . $imagem->getClientOriginalName();
            $imagem->move($pasta, $nomeImagem);
            $dados['imagem'] = "images/filmes/" . $nomeImagem;    
        }
        
        Filme::create($dados);
        
        return redirect()->to("/filmes")->with("sucesso", "Filme criado com sucesso!");
    }

    public function buscar(Request $request) {
        $busca = $request->input("busca", "");

        if (empty($busca)) {
            return redirect()->to("/filmes");
        }

        $filmes = Filme::where("titulo", "like", "%$busca%")->get();

        return view("index", ["filmes" => $filmes, "busca" => $busca]);
    }

    public function deletar($id) {
        $filme = Filme::findOrFail($id);
        $filme->delete();
        return redirect()->to("/filmes")->with("sucesso", "Filme deletado com sucesso!");
    }

    public function edit($id) {
        $filme = Filme::findOrFail($id);
        return view("edit", ["filme" => $filme]);
    }

    public function update(Request $request, $id) {
        $filme = Filme::findOrFail($id);

        $dados = $request->only(['titulo', 'descricao']);

        if ($request->hasFile("imagem")) {
            $pasta = public_path("images/filmes");
            $extensaoImagem = $request->file("imagem")->getClientOriginalExtension();
            $nomeImagem = uniqid() . "." . $extensaoImagem;

            $dados['imagem'] = "images/filmes/" . $nomeImagem;

            $request->file("imagem")->move(public_path("images/filmes"), $nomeImagem);
        }

        $filme->update($dados);
        
        return redirect()->to("/filmes")->with("sucesso", "Filme atualizado com sucesso!");
    }
}