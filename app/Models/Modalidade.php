<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modalidade extends Model
{
    use HasFactory;

    protected $table = 'Modalidades';
    protected $primaryKey = 'idModalidade';
    protected $fillable = [
        'nome',
        'descricao',
    ];
    public $timestamps = false;

    public function planos()
    {
        return $this->belongsToMany(Plano::class, 'PlanoModalidade', 'idModalidade', 'idPlano');
    }

    public function professores()
    {
        return $this->belongsToMany(Professor::class, 'ProfessorModalidade', 'idModalidade', 'idProfessor');
    }
}