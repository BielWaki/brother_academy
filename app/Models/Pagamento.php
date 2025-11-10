<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    use HasFactory;

    protected $table = 'Pagamentos';
    protected $primaryKey = 'idPagamento';
    protected $fillable = [
        'idAluno',
        'idPlano',
        'data_pagamento',
        'valor_pago',
        'status',
    ];
    public $timestamps = false;

    public function aluno()
    {
        return $this->belongsTo(Aluno::class, 'idAluno');
    }

    public function plano()
    {
        return $this->belongsTo(Plano::class, 'idPlano');
    }
}