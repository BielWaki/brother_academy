<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogOperacao extends Model
{
    use HasFactory;

    protected $table = 'logsOperacoes';
    protected $primaryKey = 'idLog';
    public $timestamps = false; 

    protected $fillable = [
        'idAluno_executor',
        'tipo_operacao',
        'tabela_afetada',
        'id_registro_afetado',
        'data_operacao',
    ];
}