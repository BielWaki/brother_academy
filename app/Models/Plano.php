<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plano extends Model
{
    use HasFactory;

    protected $table = 'Planos';
    protected $primaryKey = 'idPlano';
    protected $fillable = [
        'nomePlano',
        'valor',
        'duracaoMeses',
        'deletado',
        'data_exclusao',
        'excluido_por_idAluno',
    ];
    public $timestamps = false;

    public function modalidades()
    {
        return $this->belongsToMany(Modalidade::class, 'PlanoModalidade', 'idPlano', 'idModalidade');
    }
}