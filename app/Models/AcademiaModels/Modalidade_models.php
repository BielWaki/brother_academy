<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Modalidade extends Model
{
    use HasFactory;

    protected $table = 'Modalidades';
    protected $primaryKey = 'idModalidade';
    public $timestamps = false;

    protected $fillable = [
        'nome',
        'descricao',
        'imagemUrl',
    ];

    public function planos(): BelongsToMany
    {
        return $this->belongsToMany(
            Plano::class,
            'Plano_Modalidade', 
            'idModalidade',
            'idPlano'
        );
    }

    public function professores(): BelongsToMany
    {
        return $this->belongsToMany(
            Professor::class,
            'Professor_Modalidade', 
            'idModalidade',
            'idProfessor'
        );
    }
}