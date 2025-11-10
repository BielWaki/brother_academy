<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pagamento extends Model
{
    use HasFactory;

    protected $table = 'Pagamentos';
    protected $primaryKey = 'idPagamento';
    public $timestamps = false; 

    protected $fillable = [
        'idAluno',
        'dataPagamento',
        'valor',
        'status',
    ];

    public function aluno(): BelongsTo
    {
        return $this->belongsTo(Aluno::class, 'idAluno');
    }
}