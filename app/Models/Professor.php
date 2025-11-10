<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    use HasFactory;

    protected $table = 'Professores';
    protected $primaryKey = 'idProfessor';
    protected $fillable = [
        'nome',
        'telefone',
    ];
    public $timestamps = false;

    public function modalidades()
    {
        return $this->belongsToMany(Modalidade::class, 'ProfessorModalidade', 'idProfessor', 'idModalidade');
    }

    public function alunos()
    {
        return $this->hasMany(Aluno::class, 'idProfessor');
    }
}