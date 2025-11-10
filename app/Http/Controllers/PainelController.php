<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Treino;
use App\Models\Pagamento;
use Carbon\Carbon;

class PainelController extends Controller
{
    public function alunoDashboard()
    {
        $aluno = Auth::guard('aluno')->user();

        // Se por algum motivo não encontrar o aluno, redireciona para o login
        if (!$aluno) {
            return redirect()->route('aluno.login.form');
        }

        // Busca o treino mais recente do aluno
        $aluno->load('professor', 'plano');
        
        $treinoAtual = Treino::where('idAluno', $aluno->idAluno)
                            ->orderBy('data_inicio', 'desc')
                            ->first();

        $ultimoPagamento = Pagamento::where('idAluno', $aluno->idAluno)
                                    ->where('status', 'Pago')
                                    ->orderBy('data_pagamento', 'desc')
                                    ->first();

        $statusPagamento = 'Pendente';
        $proximoVencimento = null;

        if ($ultimoPagamento) {
            if ($aluno->plano && $aluno->plano->duracaoMeses > 0) {
                
                $dataUltimoPgto = Carbon::parse($ultimoPagamento->data_pagamento);
                
                $proximoVencimentoCarbon = $dataUltimoPgto->addMonths($aluno->plano->duracaoMeses);
                $proximoVencimento = $proximoVencimentoCarbon->format('Y-m-d');

                if ($proximoVencimentoCarbon->isPast()) {
                    $statusPagamento = 'Atrasado';
                } else {
                    $statusPagamento = 'Em dia';
                }
            } else {
                $statusPagamento = 'Em dia';
            }
        } else {
            $statusPagamento = 'Pendente';
        }

        // 4. Envia todos os dados para a view
        return view('aluno.dashboard', [
            'aluno' => $aluno,
            'treinoAtual' => $treinoAtual,
            'statusPagamento' => $statusPagamento,
            'ultimoPagamento' => $ultimoPagamento,
            'proximoVencimento' => $proximoVencimento
        ]);
    }
}