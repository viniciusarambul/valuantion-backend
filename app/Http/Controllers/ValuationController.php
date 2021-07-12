<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Valuation as Valuation;
use App\Models\Configuration;
use App\Http\Resources\Valuation as ValuationResource;

class ValuationController extends Controller
{
    public function index()
    {    
        $valuation = Valuation::paginate(15);

        return ValuationResource::collection($valuation);
      }
    
    public function show($id)
    {
        $valuation = Valuation::findOrFail( $id );

        return new ValuationResource( $valuation );
    }

    /*public function makeValuation(Request $request)
    {
        $valuation = new Valuation;
        
        $valuation->nome_pessoa = $request->input('nome_pessoa');
        $valuation->nome_empresa = $request->input('nome_empresa');
        $valuation->email = $request->input('email');
        $valuation->projecao_receita = $request->input('projecao_receita');
        $valuation->receita_atual = $request->input('receita_atual');
        
        //$this->CalcularReceitaDosAnos($valuation->receita_atual, $valuation->projecao_receita);
        

        
        $valuation->receita_ano_1 = $valuation->receita_atual+($valuation->receita_atual / 100 * $request->input('projecao_receita'));
        $valuation->receita_ano_2 = $valuation->receita_ano_1+($valuation->receita_ano_1 / 100 * $request->input('projecao_receita'));
        $valuation->receita_ano_3 = $valuation->receita_ano_2+($valuation->receita_ano_2 / 100 * $request->input('projecao_receita'));
        $valuation->receita_ano_4 = $valuation->receita_ano_3+($valuation->receita_ano_3 / 100 * $request->input('projecao_receita'));
        $valuation->receita_ano_5 = $valuation->receita_ano_4+($valuation->receita_ano_4 / 100 * $request->input('projecao_receita'));
        
        $valuation->custos_diretos = $request->input('custos_diretos');
        $valuation->custos_fixos = $request->input('custos_fixos');
        
        /*$this->CalcularEbitdaAtual(
            $valuation->receita_atual, 
            $valuation->custos_diretos, 
            $valuation->custos_fixos, 
            $valuation->projecao_receita
        );
        
        
        $valuation->ebitda_atual = $request->input('receita_atual') - ($request->input('custos_diretos')+$request->input('custos_fixos'));
        
        $valuation->margem_ebitda = (100 * $valuation->ebitda_atual) / $valuation->receita_atual;

        
        $valuation->ebitda_ano_1 = ($valuation->receita_ano_1 / 100) * $valuation->margem_ebitda;
        $valuation->ebitda_ano_2 = ($valuation->receita_ano_2 / 100) * $valuation->margem_ebitda;
        $valuation->ebitda_ano_3 = ($valuation->receita_ano_3 / 100) * $valuation->margem_ebitda;
        $valuation->ebitda_ano_4 = ($valuation->receita_ano_4 / 100) * $valuation->margem_ebitda;
        $valuation->ebitda_ano_5 = ($valuation->receita_ano_5 / 100) * $valuation->margem_ebitda;
        
        $configuration = Configuration::where('id', 1)->get();
        foreach($configuration as $config) {
            $ativo = ($config->taxa_selic + 0.2509);
            $tma = $ativo + $config->risco_brasil + ($config->beta*$config->equity);
            $taxa_perpetuidade = $tma - $valuation->projecao_receita;
            
            $valuation->perpetuidade_ano_1 = $valuation->ebitda_ano_1 / (1 + ($tma / 100));
            $valuation->perpetuidade_ano_2 = $valuation->ebitda_ano_2 / (1 + ($tma / 100)) ** 2;
            $valuation->perpetuidade_ano_3 = $valuation->ebitda_ano_3 / (1 + ($tma / 100)) ** 3;
            $valuation->perpetuidade_ano_4 = $valuation->ebitda_ano_4 / (1 + ($tma / 100)) ** 4;
            $valuation->perpetuidade_ano_5 = $valuation->ebitda_ano_5 / (1 + ($tma / 100)) ** 5;
            $valuation->perpetuidade_final = $valuation->ebitda_ano_5 / (1 + ($taxa_perpetuidade / 100));

            $valuation->resultado = $valuation->perpetuidade_ano_1 + $valuation->perpetuidade_ano_2 + $valuation->perpetuidade_ano_3 + $valuation->perpetuidade_ano_4 +   $valuation->perpetuidade_ano_5 + $valuation->perpetuidade_final;
            
            $valuation->save();
        }
        
        

        if( $valuation->save() )
        {
            return new ValuationResource( $valuation );
        }
    }
    */

    public function GetInfoFormulario(Request $request)
    {
        $nome_pessoa = $request->input('nome_pessoa');
        $nome_empresa = $request->input('nome_empresa');
        $email = $request->input('email');
        $projecao_receita = $request->input('projecao_receita');
        $receita_atual = $request->input('receita_atual');
        $custos_diretos = $request->input('custos_diretos');
        $custos_fixos = $request->input('custos_fixos');

        $info = array(
            'nome_pessoa' => $nome_pessoa,
            'nome_empresa' => $nome_empresa,
            'email' => $email,
            'projecao' => $projecao_receita,
            'receita_atual' => $receita_atual,
            'custos_diretos' => $custos_diretos,
            'custos_fixos' => $custos_fixos
        );
        
        $this->CalcularEbitdaAtual(
            $info
        );

    }

    public function CalcularEbitdaAtual(
        Array $info
    ) {
        //$valuation = new Valuation;
        $info['ebitda_atual'] = $info['receita_atual'] - ($info['custos_diretos']+$info['custos_fixos']);
        
        $this->CalcularMargemEbitda(
            $info
        );
    }

    public function CalcularMargemEbitda(
        Array $info
    ) {
        
        $info['margem_ebitda'] = (100 * $info['ebitda_atual']) / $info['receita_atual'];
        
        $this->CalcularReceitaDosAnos(
            $info
        );
    }

    public function CalcularReceitaDosAnos(
        Array $info
    ) {
        
        $receita_ano_1 = $info['receita_atual']+($info['receita_atual'] / 100 * $info['projecao']);
        $receita_ano_2 = $receita_ano_1+($receita_ano_1 / 100 * $info['projecao']);
        $receita_ano_3 = $receita_ano_2+($receita_ano_2 / 100 * $info['projecao']);
        $receita_ano_4 = $receita_ano_3+($receita_ano_3 / 100 * $info['projecao']);
        $receita_ano_5 = $receita_ano_4+($receita_ano_4 / 100 * $info['projecao']);

        $resultadoReceitas = array(
            'receita_ano_1' => $receita_ano_1,
            'receita_ano_2' => $receita_ano_2,
            'receita_ano_3' => $receita_ano_3,
            'receita_ano_4' => $receita_ano_4,
            'receita_ano_5' => $receita_ano_5,
        );
        
        $this->CalcularEbitdaProximosAnos(
            $info,
            $resultadoReceitas
        );
    }


    public function CalcularEbitdaProximosAnos(
        Array $info,
        Array $resultadoReceitas
    ) {
       
        $ebitda_ano_1 = ($resultadoReceitas['receita_ano_1']/ 100) * $info['margem_ebitda'];
        $ebitda_ano_2 = ($resultadoReceitas['receita_ano_2'] / 100) * $info['margem_ebitda'];
        $ebitda_ano_3 = ($resultadoReceitas['receita_ano_3'] / 100) * $info['margem_ebitda'];
        $ebitda_ano_4 = ($resultadoReceitas['receita_ano_4'] / 100) * $info['margem_ebitda'];
        $ebitda_ano_5 = ($resultadoReceitas['receita_ano_5'] / 100) * $info['margem_ebitda'];

        $resultadoEbitdaProximosAnos = array(
            'ebitda_ano_1' => $ebitda_ano_1,
            'ebitda_ano_2' => $ebitda_ano_2,
            'ebitda_ano_3' => $ebitda_ano_3,
            'ebitda_ano_4' => $ebitda_ano_4,
            'ebitda_ano_5' => $ebitda_ano_5,
        );

        $this->CalcularPerpetuidade(
            $info,
            $resultadoReceitas,
            $resultadoEbitdaProximosAnos
        );
        
        //$valuation->save();
    }

    public function CalcularPerpetuidade(
       Array $info,
       Array $resultadoReceitas,
       Array $resultadoEbitdaProximosAnos
    ) {
        
        $configuration = Configuration::where('id', 1)->get();
        foreach($configuration as $config) {
            $ativo = ($config->taxa_selic + 0.2509);
            $tma = $ativo + $config->risco_brasil + ($config->beta*$config->equity);
            $taxa_perpetuidade = $tma - $info['projecao'];
            
            $perpetuidade_ano_1 = $resultadoEbitdaProximosAnos['ebitda_ano_1'] / (1 + ($tma / 100));
            $perpetuidade_ano_2 = $resultadoEbitdaProximosAnos['ebitda_ano_2'] / (1 + ($tma / 100)) ** 2;
            $perpetuidade_ano_3 = $resultadoEbitdaProximosAnos['ebitda_ano_3'] / (1 + ($tma / 100)) ** 3;
            $perpetuidade_ano_4 = $resultadoEbitdaProximosAnos['ebitda_ano_4'] / (1 + ($tma / 100)) ** 4;
            $perpetuidade_ano_5 = $resultadoEbitdaProximosAnos['ebitda_ano_5'] / (1 + ($tma / 100)) ** 5;
            $perpetuidade_final = $resultadoEbitdaProximosAnos['ebitda_ano_5'] / (1 + ($taxa_perpetuidade / 100));

            $resultado = $perpetuidade_ano_1 + $perpetuidade_ano_2 + $perpetuidade_ano_3 + $perpetuidade_ano_4 + $perpetuidade_ano_5 + $perpetuidade_final;
            
            $resultadoCalculoPerpetuidade = array(
                'ativo' => $ativo,
                'tma' => $tma,
                'taxa_perpetuidade' => $taxa_perpetuidade,
                'perpetuidade_ano_1' => $perpetuidade_ano_1,
                'perpetuidade_ano_2' => $perpetuidade_ano_2,
                'perpetuidade_ano_3' => $perpetuidade_ano_3,
                'perpetuidade_ano_4' => $perpetuidade_ano_4,
                'perpetuidade_ano_5' => $perpetuidade_ano_5,
                'perpetuidade_final' => $perpetuidade_final,
                'resultado' => $resultado
            );

            $this->SalvarValuation($info, $resultadoReceitas, $resultadoEbitdaProximosAnos, $resultadoCalculoPerpetuidade);
        }
        
    }

    public function SalvarValuation(
        Array $info,
        Array $resultadoReceitas,
        Array $resultadoEbitdaProximosAnos,
        Array $resultadoCalculoPerpetuidade
    ) {
        $valuation = new Valuation;

        $valuation->nome_pessoa = $info['nome_pessoa'];
        $valuation->nome_empresa = $info['nome_empresa'];
        $valuation->email = $info['email'];
        $valuation->projecao_receita = $info['projecao'];
        $valuation->receita_atual = $info['receita_atual'];
        $valuation->custos_diretos = $info['custos_diretos'];
        $valuation->custos_fixos = $info['custos_fixos'];
        $valuation->receita_ano_1 = $resultadoReceitas['receita_ano_1'];
        $valuation->receita_ano_2 = $resultadoReceitas['receita_ano_2'];
        $valuation->receita_ano_3 = $resultadoReceitas['receita_ano_3'];
        $valuation->receita_ano_4 = $resultadoReceitas['receita_ano_4'];
        $valuation->receita_ano_5 = $resultadoReceitas['receita_ano_5'];
        $valuation->ebitda_atual = $info['ebitda_atual'];
        $valuation->margem_ebitda = $info['margem_ebitda'];
        $valuation->ebitda_ano_1 = $resultadoEbitdaProximosAnos['ebitda_ano_1'];
        $valuation->ebitda_ano_2 = $resultadoEbitdaProximosAnos['ebitda_ano_2'];
        $valuation->ebitda_ano_3 = $resultadoEbitdaProximosAnos['ebitda_ano_3'];
        $valuation->ebitda_ano_4 = $resultadoEbitdaProximosAnos['ebitda_ano_4'];
        $valuation->ebitda_ano_5 = $resultadoEbitdaProximosAnos['ebitda_ano_5'];
        $valuation->perpetuidade_ano_1 = $resultadoCalculoPerpetuidade['perpetuidade_ano_1'];
        $valuation->perpetuidade_ano_2 = $resultadoCalculoPerpetuidade['perpetuidade_ano_2'];
        $valuation->perpetuidade_ano_3 = $resultadoCalculoPerpetuidade['perpetuidade_ano_3'];
        $valuation->perpetuidade_ano_4 = $resultadoCalculoPerpetuidade['perpetuidade_ano_4'];
        $valuation->perpetuidade_ano_5 = $resultadoCalculoPerpetuidade['perpetuidade_ano_5'];
        $valuation->perpetuidade_final = $resultadoCalculoPerpetuidade['perpetuidade_final'];
        $valuation->resultado = $resultadoCalculoPerpetuidade['resultado'];
        
        if( $valuation->save() )
        {
            return new ValuationResource( $valuation );
        }

    }

}