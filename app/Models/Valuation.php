<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Valuation extends Model
{
    use HasFactory;
    protected $table = 'valuations';
    protected $fillable = [
        'nome_pessoa',
        'nome_empresa',
        'email', 
        'receita_autal',
        'projecao_receita',
        'custos_diretos', 
        'custos_fixos'
    ];
}
