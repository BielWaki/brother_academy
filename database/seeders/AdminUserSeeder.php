<?php

namespace Database\Seeders; 

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminExists = DB::table('users')->where('email', 'admin@academia.com')->exists();

        if (!$adminExists) {
            DB::table('users')->insert([
                'name' => 'Administrador Geral',
                'email' => 'admin@academia.com',
                'password' => Hash::make('12345678'), 
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
        
        $modalidade = DB::table('Modalidades')->where('nome', 'Fitness Geral')->first();
        if (!$modalidade) {
            DB::table('Modalidades')->insert([
                'nome' => 'Fitness Geral',
                'descricao' => 'Treinos de musculação e cárdio com acompanhamento padrão.',
            ]);
        }

        $plano = DB::table('Planos')->where('nomePlano', 'Plano Basic')->first();
        if (!$plano) {
            DB::table('Planos')->insert([
                'nomePlano' => 'Plano Basic',
                'valor' => 99.90,
                'duracaoMeses' => 1,
            ]);
        }
    }
}