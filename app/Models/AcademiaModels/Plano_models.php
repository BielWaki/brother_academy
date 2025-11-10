<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
// Não usaremos o SoftDeletes padrão do Laravel aqui, pois você usa um campo 'deletado' TINYINT
// em vez de 'deleted_at'. Vamos customizar o comportamento se for necessário, mas por enquanto, mantemos o Model simples.

class Plano extends Model
{
    use HasFactory;

    protected $table = 'Planos';
    protected $primaryKey = 'idPlano';

    // Sobrescreve os nomes dos timestamps
    public const CREATED_AT = 'data_criacao';
    public const UPDATED_AT = 'data_modificacao';

    protected $fillable = [
        'nomePlano',
        'valor',
        'duracaoMeses',
        'deletado', 
        'data_exclusao',
        'excluido_por_idAluno',
    ];

    protected $dates = ['data_exclusao'];

    public function alunos(): HasMany
    {
        return $this->hasMany(Aluno::class, 'idPlano');
    }

    public function modalidades(): BelongsToMany
    {
        return $this->belongsToMany(
            Modalidade::class,
            'Plano_Modalidade',
            'idPlano',
            'idModalidade'
        );
    }
}