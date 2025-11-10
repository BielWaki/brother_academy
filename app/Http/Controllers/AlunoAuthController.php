<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Plano;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AlunoAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('aluno.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'senha' => 'required|string',
        ]);

        $email = $request->email;
        $senhaNaoCriptografada = $request->senha;
        //Chama a procedure de validação de login
        try {
            $resultado = DB::select(
                'CALL validaLogin(?, ?)', 
                [$email, $senhaNaoCriptografada]
            );
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Erro ao conectar com o banco de dados.'])->onlyInput('email');
        }

        if (empty($resultado)) {
            return back()->withErrors(['email' => 'Erro inesperado da procedure.'])->onlyInput('email');
        }

        $resposta = $resultado[0];

        //analisa a resposta da procedure
        if ($resposta->status == 'ok') {
            $aluno = Aluno::find($resposta->idaluno);
            if (!$aluno) {
                return back()->withErrors(['email' => 'Procedure aprovou, mas aluno não encontrado no Laravel.'])->onlyInput('email');
            }
            
            Auth::guard('aluno')->login($aluno);
            
            $request->session()->regenerate();

            return redirect()->intended(route('aluno.dashboard'))
                            ->with('success', 'Login realizado com sucesso!');
        } 
        
        else {
            // A procedure fala se tem o erro
            return back()->withErrors([
                'email' => $resposta->mensagem
            ])->onlyInput('email');
        }
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
     * Processa o registro de um novo aluno
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
                'senha' => hash('sha256', $validatedData['senha']), //troca do Bcrypt para SHA2
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

    /**
     * Mostra o formulario de alterar senha.
     */
    public function showChangePasswordForm()
    {
        return view('aluno.mudaSenha');
    }

    /**
     * atualiza a senha (chamando a procedure).
     */
    public function updatePassword(Request $request)
    {
        // Pega o aluno que está logado
        $aluno = Auth::guard('aluno')->user();

        //Validar os dados do formulário
        $request->validate([
            'senha_antiga' => 'required',
            'senha_nova' => ['required', 'confirmed', Password::min(8)],
        ], [
            'senha_antiga.required' => 'Você precisa digitar sua senha antiga.',
            'senha_nova.required' => 'Você precisa digitar uma nova senha.',
            'senha_nova.confirmed' => 'A confirmação da nova senha não bate.',
        ]);

        // Verificar se a SENHA ANTIGA está correta
        if (hash('sha256', $request->senha_antiga) !== $aluno->senha) {
            return back()->withErrors([
                'senha_antiga' => 'A senha antiga está incorreta.'
            ]);
        }

        // A sua procedure 'trocarsenha' também usa SHA2, então mandamos a senha nova sem criptografar.
        try {
            $resultado = DB::select(
                'CALL trocarsenha(?, ?, ?)',
                [$aluno->idAluno, $request->senha_antiga, $request->senha_nova]
            );
            
            $resposta = $resultado[0];

            if ($resposta->status == 'ok') {
                return back()->with('success', $resposta->mensagem);
            } else {
                return back()->withErrors([
                    'senha_antiga' => $resposta->mensagem
                ]);
            }
            
        } catch (\Exception $e) {
            return back()->withErrors(['db_error' => 'Erro ao salvar a senha no banco: ' . $e->getMessage()]);
        }
    }
}