<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class Valuation extends JsonResource {
  public function toArray($info){
    dd($info);
    //return parent::toArray($request);
    return [
      'id' => $this->id,
      'nome_pessoa' => $this->nome_pessoa,
      'nome_empresa' => $this->nome_empresa,
      'email' => $this->email,
      'receita_atual' => $this->receita_atual,
      'projeca_receita' => $this->projecao_receita,
      'receita_ano_1' => $this->receita_ano_1,
      'receita_ano_2' => $this->receita_ano_2,
      'receita_ano_3' => $this->receita_ano_3,
      'receita_ano_4' => $this->receita_ano_4,
      'receita_ano_5' => $this->receita_ano_5,
      'custos_diretos' => $this->custos_diretos,
      'custos_fixos' => $this->custos_fixos,
      'ebitda_atual' => $this->ebitda_atual,
      'ebitda_ano_1' => $this->ebitda_ano_1,
      'ebitda_ano_2' => $this->ebitda_ano_2,
      'ebitda_ano_3' => $this->ebitda_ano_3,
      'ebitda_ano_4' => $this->ebitda_ano_4,
      'ebitda_ano_5' => $this->ebitda_ano_5,
      'margem_ebitda' => $this->margem_ebitda,
      'projecao_receita' => $this->projecao_receita,
      'perpetuidade_ano_1' => $this->perpetuidade_ano_1,
      'perpetuidade_ano_2' => $this->perpetuidade_ano_2,
      'perpetuidade_ano_3' => $this->perpetuidade_ano_3,
      'perpetuidade_ano_4' => $this->perpetuidade_ano_4,
      'perpetuidade_ano_5' => $this->perpetuidade_ano_5,
      'perpetuidade_final' => $this->perpetuidade_final,
      'resultado' => $this->resultado
    ];
  }
}