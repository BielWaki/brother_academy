<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Treino extends Model
{
    use HasFactory;

    protected $table = 'Treinos';
    protected $primaryKey = 'idTreino';
    public $timestamps = false;

    protected $fillable = [
        'idAluno',
        'descricao',
        'data_inicio',
        'data_fim',
    ];

    public function aluno(): BelongsTo
    {
        return $this->belongsTo(Aluno::class, 'idAluno');
    }
}