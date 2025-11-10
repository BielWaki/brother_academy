<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Professor extends Model
{
    use HasFactory;

    protected $table = 'Professores';
    protected $primaryKey = 'idProfessor';
    public $timestamps = false; 

    protected $fillable = [
        'nome',
        'telefone',
    ];

    public function alunos(): HasMany
    {
        return $this->hasMany(Aluno::class, 'idProfessor');
    }

    public function modalidades(): BelongsToMany
    {
        return $this->belongsToMany(
            Modalidade::class,
            'Professor_Modalidade',
            'idProfessor',
            'idModalidade'
        );
    }
}