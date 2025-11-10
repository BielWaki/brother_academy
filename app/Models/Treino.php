<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treino extends Model
{
    use HasFactory;

    protected $table = 'Treinos';
    protected $primaryKey = 'idTreino';
    protected $fillable = [
        'idAluno',
        'descricao',
        'data_inicio',
        'data_fim',
    ];
    public $timestamps = false;

    public function aluno()
    {
        return $this->belongsTo(Aluno::class, 'idAluno');
    }
}