<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class Configuration extends JsonResource {
  public function toArray($request){
    //return parent::toArray($request);
    return [
      'id' => $this->id,
      'ativo_livre' => $this->ativo_livre,
      'equity' => $this->equity,
      'risco_brasil' => $this->risco_brasil,
      'taxa_selic' => $this->taxa_selic,
      'beta' => $this->beta
    ];
  }
}