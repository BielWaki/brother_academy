<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
     // Mostra o formulário de login do admin.
    public function showLoginForm()
    {
        // Se o admin já estiver logado, manda ele pro dashboard
        if (Auth::guard('web')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

     // Processa a tentativa de login do admin.
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Tenta autenticar usando a "guarda" 'web' (a padrão do Laravel, que usa a tabela 'users')
        if (Auth::guard('web')->attempt($credentials, $request->filled('remember'))) {
            
            $request->session()->regenerate();
            
            // Redireciona para o dashboard do admin
            return redirect()->intended(route('admin.dashboard'))
                             ->with('success', 'Login de admin realizado com sucesso!');
        }

        return back()->withErrors([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ])->onlyInput('email');
    }

    /**
     * Faz o logout do admin.
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}