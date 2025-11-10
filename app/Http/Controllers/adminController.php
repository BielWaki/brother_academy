<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plano;
use App\Models\Modalidade;
use App\Models\Professor;
use App\Models\Aluno;
use App\Models\Treino;
use App\Models\Pagamento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Hash; 
use Carbon\Carbon; // Adicionamos o Carbon para manipulação de data

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function indexPagamentos()
    {
        $pagamentos = Pagamento::with('aluno', 'plano')->orderBy('data_pagamento', 'desc')->get();
        return view('admin.pagamentos.index', compact('pagamentos'));
    }

    public function createPagamentos()
    {
        $isEdit = false;
        $alunos = Aluno::orderBy('nome', 'asc')->get();
        $planos = Plano::where('deletado', 0)->orderBy('nomePlano', 'asc')->get();
        
        return view('admin.pagamentos.create_edit', compact('isEdit', 'alunos', 'planos'));
    }

    public function storePagamentos(Request $request)
    {
        $validatedData = $request->validate([
            'idAluno' => 'required|exists:Alunos,idAluno',
            'idPlano' => 'required|exists:Planos,idPlano',
            'valor_pago' => 'required|numeric|min:0.01',
            'data_pagamento' => 'required|date',
            'status' => 'required|string',
        ]);
        
        try {
            Pagamento::create($validatedData);
            return redirect()->route('pagamentos.index')->with('success', 'Pagamento registrado com sucesso!');
            
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erro ao salvar o pagamento: ' . $e->getMessage()])->withInput();
        }
    }
    
    public function indexPlanos()
    {
        $planos = Plano::orderBy('valor', 'asc')->get();
        return view('admin.planos.index', compact('planos'));
    }

    public function createPlanos()
    {
        $plano = new Plano();
        $isEdit = false;
        $modalidades = Modalidade::all();
        $modalidadesAssociadasIds = [];
        return view('admin.planos.create_edit', compact('plano', 'isEdit', 'modalidades', 'modalidadesAssociadasIds'));
    }

    public function storePlanos(Request $request)
    {
        $validatedData = $request->validate([
            'nomePlano' => 'required|string|max:50|unique:Planos,nomePlano',
            'valor' => 'required|numeric|min:0.01',
            'duracaoMeses' => 'required|integer|min:1',
            'modalidades_ids' => 'nullable|array',
            'modalidades_ids.*' => 'exists:Modalidades,idModalidade',
        ]);
        
        $idAlunoExecutor = 1;

        try {
            DB::transaction(function () use ($validatedData, $idAlunoExecutor) {
                
                $plano = Plano::create($validatedData);

                if (!empty($validatedData['modalidades_ids'])) {
                    $plano->modalidades()->sync($validatedData['modalidades_ids']);
                }
            });

            return redirect()->route('planos.index')->with('success', 'Plano criado com sucesso!');
            
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erro ao salvar o plano: ' . $e->getMessage()])->withInput();
        }
    }

    public function editPlanos($id)
    {
        $plano = Plano::findOrFail($id);
        $isEdit = true;
        $modalidades = Modalidade::all();
        $modalidadesAssociadasIds = $plano->modalidades()->pluck('idModalidade')->toArray();

        return view('admin.planos.create_edit', compact('plano', 'isEdit', 'modalidades', 'modalidadesAssociadasIds'));
    }

    public function updatePlanos(Request $request, $id)
    {
        $plano = Plano::findOrFail($id);

        $validatedData = $request->validate([
            'nomePlano' => 'required|string|max:50|unique:Planos,nomePlano,' . $id . ',idPlano', 
            'valor' => 'required|numeric|min:0.01',
            'duracaoMeses' => 'required|integer|min:1',
            'modalidades_ids' => 'nullable|array',
            'modalidades_ids.*' => 'exists:Modalidades,idModalidade',
        ]);
        
        $idAlunoExecutor = 1;

        try {
            DB::transaction(function () use ($validatedData, $plano, $idAlunoExecutor) {
                
                $plano->update($validatedData);
                $plano->modalidades()->sync($validatedData['modalidades_ids'] ?? []);
            });

            return redirect()->route('planos.index')->with('success', 'Plano atualizado com sucesso!');
            
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erro ao atualizar o plano: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroyPlanos($id)
    {
        $plano = Plano::findOrFail($id);
        $idAlunoExecutor = 1;

        try {
            $plano->update([
                'deletado' => 1,
                'data_exclusao' => now(),
                'excluido_por_idAluno' => $idAlunoExecutor,
            ]);
            return redirect()->route('planos.index')->with('success', 'Plano desativado com sucesso!');
            
        } catch (\Exception $e) {
             return back()->withErrors(['error' => 'Erro ao desativar o plano.']);
        }
    }

    public function restorePlanos($id)
    {
        $plano = Plano::findOrFail($id);
        
        try {
            $plano->update([
                'deletado' => 0,
                'data_exclusao' => null,
                'excluido_por_idAluno' => null,
            ]);

            return redirect()->route('planos.index')->with('success', 'Plano reativado com sucesso!');
            
        } catch (\Exception $e) {
             return back()->withErrors(['error' => 'Erro ao reativar o plano.']);
        }
    }

    public function indexModalidades()
    {
        $modalidades = Modalidade::orderBy('nome', 'asc')->get();
        return view('admin.modalidades.index', compact('modalidades'));
    }

    public function createModalidades()
    {
        $modalidade = new Modalidade();
        $isEdit = false;
        return view('admin.modalidades.create_edit', compact('modalidade', 'isEdit'));
    }

    public function storeModalidades(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:50|unique:Modalidades,nome',
            'descricao' => 'nullable|string|max:500',
        ]);
        
        try {
            DB::transaction(function () use ($validatedData) {
                Modalidade::create($validatedData);
            });
            return redirect()->route('modalidades.index')->with('success', 'Modalidade criada com sucesso!');
            
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erro ao salvar a modalidade: ' . $e->getMessage()])->withInput();
        }
    }

    public function editModalidades($id)
    {
        $modalidade = Modalidade::findOrFail($id);
        $isEdit = true;
        return view('admin.modalidades.create_edit', compact('modalidade', 'isEdit'));
    }

    public function updateModalidades(Request $request, $id)
    {
        $modalidade = Modalidade::findOrFail($id);

        $validatedData = $request->validate([
            'nome' => 'required|string|max:50|unique:Modalidades,nome,' . $id . ',idModalidade', 
            'descricao' => 'nullable|string|max:500',
        ]);
        
        try {
            DB::transaction(function () use ($validatedData, $modalidade) {
                $modalidade->update($validatedData);
            });
            return redirect()->route('modalidades.index')->with('success', 'Modalidade atualizada com sucesso!');
            
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erro ao atualizar a modalidade: . ' . $e->getMessage()])->withInput();
        }
    }

    public function destroyModalidades($id)
    {
        $modalidade = Modalidade::findOrFail($id);
        $idAlunoExecutor = 1;

        try {
            $modalidade->delete();
            return redirect()->route('modalidades.index')->with('success', 'Modalidade excluída com sucesso.');
            
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erro ao excluir a modalidade. Verifique se há planos ou professores associados.']);
        }
    }

    public function indexProfessores()
    {
        $professores = Professor::orderBy('nome', 'asc')->get();
        $professores->load('modalidades'); 
        return view('admin.professores.index', compact('professores'));
    }

    public function createProfessores()
    {
        $professor = new Professor();
        $isEdit = false;
        $modalidades = Modalidade::all();
        $modalidadesAssociadasIds = [];
        return view('admin.professores.create_edit', compact('professor', 'isEdit', 'modalidades', 'modalidadesAssociadasIds'));
    }

    public function storeProfessores(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:100',
            'telefone' => 'nullable|string|max:20',
            'modalidades_ids' => 'nullable|array',
            'modalidades_ids.*' => 'exists:Modalidades,idModalidade',
        ]);
        
        try {
            DB::transaction(function () use ($validatedData) {
                
                $professor = Professor::create([
                    'nome' => $validatedData['nome'],
                    'telefone' => $validatedData['telefone'],
                ]);

                if (!empty($validatedData['modalidades_ids'])) {
                    $professor->modalidades()->sync($validatedData['modalidades_ids']);
                }
            });

            return redirect()->route('professores.index')->with('success', 'Professor criado com sucesso!');
            
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erro ao salvar o professor: ' . $e->getMessage()])->withInput();
        }
    }

    public function editProfessores($id)
    {
        $professor = Professor::findOrFail($id);
        $isEdit = true;
        $modalidades = Modalidade::all();
        $modalidadesAssociadasIds = $professor->modalidades()->pluck('idModalidade')->toArray();

        return view('admin.professores.create_edit', compact('professor', 'isEdit', 'modalidades', 'modalidadesAssociadasIds'));
    }

    public function updateProfessores(Request $request, $id)
    {
        $professor = Professor::findOrFail($id);

        $validatedData = $request->validate([
            'nome' => 'required|string|max:100',
            'telefone' => 'nullable|string|max:20',
            'modalidades_ids' => 'nullable|array',
            'modalidades_ids.*' => 'exists:Modalidades,idModalidade',
        ]);
        
        try {
            DB::transaction(function () use ($validatedData, $professor) {
                
                $professor->update($validatedData);
                $professor->modalidades()->sync($validatedData['modalidades_ids'] ?? []);
            });

            return redirect()->route('professores.index')->with('success', 'Professor atualizado com sucesso!');
            
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erro ao atualizar o professor: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroyProfessores($id)
    {
        $professor = Professor::findOrFail($id);
        
        try {
            $professor->modalidades()->sync([]);
            $professor->delete();

            return redirect()->route('professores.index')->with('success', 'Professor excluído permanentemente.');
            
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erro ao excluir o professor. Verifique se há alunos ou referências pendentes.']);
        }
    }
    
    public function indexAlunos()
    {
        $alunos = Aluno::with('plano', 'professor')->orderBy('nome', 'asc')->get();

        return view('admin.alunos.index', compact('alunos'));
    }

    public function createAlunos()
    {
        $aluno = new Aluno();
        $isEdit = false;
        $planos = Plano::where('deletado', 0)->get();
        $professores = Professor::orderBy('nome', 'asc')->get();

        return view('admin.alunos.create_edit', compact('aluno', 'isEdit', 'planos', 'professores'));
    }

    public function storeAlunos(Request $request)
    {
        // 1. Validação de segurança
        $validatedData = $request->validate([
            'nome' => 'required|string|max:100',
            'data_nascimento' => 'required|date',
            'telefone' => 'nullable|string|max:20',
            'email' => 'required|email|unique:Alunos,email',
            'senha' => 'required|string|min:8|confirmed',
            'idPlano' => 'nullable|exists:Planos,idPlano',
            'idProfessor' => 'nullable|exists:Professores,idProfessor',
            'status_bloqueio' => 'nullable|boolean',
        ]);
        
        try {
            // 2. Criação do Aluno
            Aluno::create([
                'nome' => $validatedData['nome'],
                'data_nascimento' => $validatedData['data_nascimento'],
                'telefone' => $validatedData['telefone'],
                'email' => $validatedData['email'],
                'senha' => Hash::make($validatedData['senha']),
                'idPlano' => $validatedData['idPlano'] ?? null,
                'idProfessor' => $validatedData['idProfessor'] ?? null,
                'status_bloqueio' => $validatedData['status_bloqueio'] ?? 0,
                'tentativas_login' => 0,
            ]);

            return redirect()->route('alunos.index')->with('success', 'Aluno matriculado com sucesso!');
            
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erro ao matricular o aluno: ' . $e->getMessage()])->withInput();
        }
    }

    public function editAlunos($id)
    {
        $aluno = Aluno::findOrFail($id);
        $isEdit = true;
        $planos = Plano::where('deletado', 0)->get();
        $professores = Professor::orderBy('nome', 'asc')->get();

        return view('admin.alunos.create_edit', compact('aluno', 'isEdit', 'planos', 'professores'));
    }

    public function updateAlunos(Request $request, $id)
    {
        $aluno = Aluno::findOrFail($id);

        $validatedData = $request->validate([
            'nome' => 'required|string|max:100',
            'data_nascimento' => 'required|date',
            'telefone' => 'nullable|string|max:20',
            'email' => 'required|email|unique:Alunos,email,' . $id . ',idAluno',
            'senha' => 'nullable|string|min:8|confirmed',
            'idPlano' => 'nullable|exists:Planos,idPlano',
            'idProfessor' => 'nullable|exists:Professores,idProfessor',
            'status_bloqueio' => 'nullable|boolean',
        ]);
        
        try {
            $dataToUpdate = [
                'nome' => $validatedData['nome'],
                'data_nascimento' => $validatedData['data_nascimento'],
                'telefone' => $validatedData['telefone'],
                'email' => $validatedData['email'],
                'idPlano' => $validatedData['idPlano'] ?? null,
                'idProfessor' => $validatedData['idProfessor'] ?? null,
                'status_bloqueio' => $validatedData['status_bloqueio'] ?? 0,
            ];
            
            if (!empty($validatedData['senha'])) {
                $dataToUpdate['senha'] = Hash::make($validatedData['senha']);
            }
            
            $aluno->update($dataToUpdate);

            return redirect()->route('alunos.index')->with('success', 'Dados do aluno atualizados com sucesso!');
            
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erro ao atualizar o aluno: ' . $e->getMessage()])->withInput();
        }
    }

    public function toggleBlockAlunos($id)
    {
        $aluno = Aluno::findOrFail($id);
        $novoStatus = !$aluno->status_bloqueio;
        
        try {
            $aluno->update([
                'status_bloqueio' => $novoStatus,
                'tentativas_login' => 0,
            ]);
            
            $mensagem = $novoStatus ? 'Aluno bloqueado com sucesso.' : 'Aluno desbloqueado com sucesso.';
            
            return redirect()->route('alunos.index')->with('success', $mensagem);
            
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erro ao alterar o status de bloqueio.']);
        }
    }

    public function indexTreinos(Request $request)
    {
        $query = Treino::with('aluno')->orderBy('data_inicio', 'desc');

        if ($request->has('idAluno') && $request->idAluno) {
            $query->where('idAluno', $request->idAluno);
        }

        $treinos = $query->get();
        $alunos = Aluno::orderBy('nome', 'asc')->get(['idAluno', 'nome']);

        return view('admin.treinos.index', compact('treinos', 'alunos'));
    }

    public function createTreinos(Request $request)
    {
        $treino = new Treino();
        $isEdit = false;
        $alunos = Aluno::orderBy('nome', 'asc')->get(['idAluno', 'nome']);
        $idAlunoPreselecionado = $request->input('idAluno');

        return view('admin.treinos.create_edit', compact('treino', 'isEdit', 'alunos', 'idAlunoPreselecionado'));
    }

    public function storeTreinos(Request $request)
    {
        $validatedData = $request->validate([
            'idAluno' => 'required|exists:Alunos,idAluno',
            'descricao' => 'required|string',
            'data_inicio' => 'required|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
        ]);
        
        try {
            Treino::create($validatedData);

            return redirect()->route('treinos.index', ['idAluno' => $validatedData['idAluno']])->with('success', 'Treino criado com sucesso!');
            
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erro ao salvar o treino: ' . $e->getMessage()])->withInput();
        }
    }

    public function editTreinos($id)
    {
        $treino = Treino::findOrFail($id);
        $isEdit = true;
        $alunos = Aluno::orderBy('nome', 'asc')->get(['idAluno', 'nome']);
        $idAlunoPreselecionado = $treino->idAluno;

        return view('admin.treinos.create_edit', compact('treino', 'isEdit', 'alunos', 'idAlunoPreselecionado'));
    }

    public function updateTreinos(Request $request, $id)
    {
        $treino = Treino::findOrFail($id);

        $validatedData = $request->validate([
            'idAluno' => 'required|exists:Alunos,idAluno',
            'descricao' => 'required|string',
            'data_inicio' => 'required|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
        ]);
        
        try {
            $treino->update($validatedData);

            return redirect()->route('treinos.index', ['idAluno' => $validatedData['idAluno']])->with('success', 'Treino atualizado com sucesso!');
            
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erro ao atualizar o treino: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroyTreinos($id)
    {
        $treino = Treino::findOrFail($id);
        $idAluno = $treino->idAluno;
        
        try {
            $treino->delete();

            return redirect()->route('treinos.index', ['idAluno' => $idAluno])->with('success', 'Treino excluído permanentemente.');
            
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erro ao excluir o treino.']);
        }
    }
}