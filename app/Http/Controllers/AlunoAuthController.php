<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Aluno;
use App\Models\Plano;

class AlunoAuthController extends Controller
{
    /**
     * Mostra o formulário de login do aluno.
     */
    public function showLoginForm()
    {
        return view('aluno.login');
    }

    /**
     * Processa a tentativa de login do aluno.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'senha' => 'required|string',
        ]);

        $credentials['password'] = $credentials['senha'];
        unset($credentials['senha']);

        if (Auth::guard('aluno')->attempt($credentials, $request->filled('remember'))) {
            
            $aluno = Auth::guard('aluno')->user();

            if ($aluno->status_bloqueio) {
                Auth::guard('aluno')->logout();
                return back()->withErrors([
                    'email' => 'Esta conta está bloqueada. Entre em contato com a administração.',
                ])->onlyInput('email');
            }

            $aluno->tentativas_login = 0;
            $aluno->save();

            $request->session()->regenerate();
            
            return redirect()->intended(route('aluno.dashboard'))
                             ->with('success', 'Login realizado com sucesso!');
        }

        $aluno = Aluno::where('email', $credentials['email'])->first();
        if ($aluno && !$aluno->status_bloqueio) {
            $aluno->tentativas_login += 1;
            if ($aluno->tentativas_login >= 5) {
                $aluno->status_bloqueio = 1;
            }
            $aluno->save();
        }

        return back()->withErrors([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ])->onlyInput('email');
    }

    /**
     * Mostra o formulário de matrícula (registro) do aluno.
     */
    public function showRegistrationForm()
    {
        $planos = Plano::where('deletado', 0)->orderBy('valor', 'asc')->get();
        return view('aluno.register', compact('planos'));
    }

    /**
     * Processa o registro de um novo aluno (matrícula).
     */
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:100',
            'data_nascimento' => 'required|date',
            'telefone' => 'nullable|string|max:20',
            'email' => 'required|email|unique:Alunos,email',
            'senha' => 'required|string|min:8|confirmed',
            'idPlano' => 'required|exists:Planos,idPlano',
        ]);

        try {
            $aluno = Aluno::create([
                'nome' => $validatedData['nome'],
                'data_nascimento' => $validatedData['data_nascimento'],
                'telefone' => $validatedData['telefone'],
                'email' => $validatedData['email'],
                'senha' => Hash::make($validatedData['senha']),
                'idPlano' => $validatedData['idPlano'],
                'status_bloqueio' => 0,
                'tentativas_login' => 0,
            ]);

            Auth::guard('aluno')->login($aluno);

            return redirect()->route('aluno.dashboard')
                             ->with('success', 'Matrícula realizada! Bem-vindo(a)!');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erro ao realizar a matrícula: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Faz o logout do aluno.
     */
    public function logout(Request $request)
    {
        Auth::guard('aluno')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}