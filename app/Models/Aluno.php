<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Aluno extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'Alunos';
    protected $primaryKey = 'idAluno';
    protected $guard = 'aluno';

    protected $fillable = [
        'nome',
        'data_nascimento',
        'telefone',
        'email',
        'senha',
        'idPlano',
        'idProfessor',
        'status_bloqueio',
        'tentativas_login',
    ];

    protected $hidden = [
        'senha',
    ];

    public $timestamps = false;
    
    public function getAuthPassword()
    {
        return $this->senha;
    }

    public function plano()
    {
        return $this->belongsTo(Plano::class, 'idPlano');
    }

    public function professor()
    {
        return $this->belongsTo(Professor::class, 'idProfessor');
    }
    
    public function treinos()
    {
        return $this->hasMany(Treino::class, 'idAluno');
    }
    
    public function pagamentos()
    {
        return $this->hasMany(Pagamento::class, 'idAluno');
    }
}