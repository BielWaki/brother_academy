<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable; // Importante para o Auth Guard

class Aluno extends Authenticatable
{
    use HasFactory;

    // Sobrescreve o nome da tabela
    protected $table = 'Alunos';

    // Sobrescreve a chave primária
    protected $primaryKey = 'idAluno';

    // Desabilita timestamps automáticos (você não definiu created_at/updated_at)
    public $timestamps = false; 

    // Oculta a senha ao serializar o Model (usando o nome do seu campo)
    protected $hidden = [
        'senha',
    ];
    
    // Sobrescreve o campo de senha padrão do Laravel (de 'password' para 'senha')
    public function getAuthPassword()
    {
        return $this->senha;
    }

    protected $fillable = [
        'nome',
        'data_nascimento',
        'telefone',
        'email',
        'senha', 
        'idPlano',
        'idProfessor',
        'tentativas_login',
        'status_bloqueio',
    ];

    // Relacionamentos
    public function plano(): BelongsTo
    {
        return $this->belongsTo(Plano::class, 'idPlano');
    }

    public function professor(): BelongsTo
    {
        return $this->belongsTo(Professor::class, 'idProfessor');
    }
    
    public function pagamentos(): HasMany
    {
        return $this->hasMany(Pagamento::class, 'idAluno');
    }

    public function treinos(): HasMany
    {
        return $this->hasMany(Treino::class, 'idAluno');
    }
}