<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pagamento;
use App\Models\Treino;
use Carbon\Carbon;

class PainelController extends Controller
{

    public function alunoDashboard()
    {
        $aluno = Auth::guard('aluno')->user();

        if (!$aluno) {
            return redirect()->route('aluno.login.form');
        }


        $aluno->load('professor', 'plano.modalidades');
        
        $ultimoPagamento = Pagamento::where('idAluno', $aluno->idAluno)
                                    ->where('status', 'PAGO')
                                    ->orderBy('data_pagamento', 'desc')
                                    ->first();

        $statusPagamento = 'Pendente';
        $proximoVencimento = null;

        if ($ultimoPagamento) {
            if ($aluno->plano && $aluno->plano->duracaoMeses > 0) {
                
                $dataUltimoPgto = Carbon::parse($ultimoPagamento->dataPagamento);
                
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

        return view('aluno.dashboard', [
            'aluno' => $aluno,
            'statusPagamento' => $statusPagamento,
            'ultimoPagamento' => $ultimoPagamento,
            'proximoVencimento' => $proximoVencimento
        ]);
    }

    public function showPerfil()
    {
        $aluno = Auth::guard('aluno')->user();
        $aluno->load('plano', 'professor');

        return view('aluno.perfil', [
            'aluno' => $aluno
        ]);
    }
    public function showPagamentos()
    {
        $idAluno = Auth::guard('aluno')->id();

        $pagamentos = Pagamento::where('idAluno', $idAluno)
                                ->orderBy('data_pagamento', 'desc')
                                ->get();

        return view('aluno.pagamentos', [
            'pagamentos' => $pagamentos
        ]);
    }
}