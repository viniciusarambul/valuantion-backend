<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuration as Configuration;
use App\Http\Resources\Configuration as ConfigurationResource;

class ConfigurationController extends Controller
{
    public function index(){
        $configurations = Configuration::paginate(15);
        return ConfigurationResource::collection($configurations);
      }
    
      public function show($id){
        $configuration = Configuration::findOrFail( $id );
        return new ConfigurationResource( $configuration );
      }
    
      public function store(Request $request){
        $configuration = new Configuration;
        $configuration->ativo_livre = $request->input('ativo_livre');
        $configuration->equity = $request->input('equity');
        $configuration->risco_brasil = $request->input('risco_brasil');
        $configuration->taxa_selic = $request->input('taxa_selic');
        $configuration->beta = $request->input('beta');
    
        if( $configuration->save() ){
          return new ConfigurationResource( $configuration );
        }
      }
    
       public function update(Request $request){
        $configuration = Configuration::findOrFail( $request->id );
        $configuration->ativo_livre = $request->input('ativo_livre');
        $configuration->equity = $request->input('equity');
        $configuration->risco_brasil = $request->input('risco_brasil');
        $configuration->taxa_selic = $request->input('taxa_selic');
        $configuration->beta = $request->input('beta');
    
        if( $configuration->save() ){
          return new ConfigurationResource( $configuration );
        }
      } 
    
      public function destroy($id){
        $configuration = Configuration::findOrFail( $id );
        if( $configuration->delete() ){
          return new ConfigurationResource( $configuration );
        }
    
      }
    }