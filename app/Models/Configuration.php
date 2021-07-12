<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    use HasFactory;
    protected $table = 'configuration_values';
    protected $fillable = ['ativo_livre', 'equity', 'risco_brasil', 'taxa_selic', 'beta'];
}
