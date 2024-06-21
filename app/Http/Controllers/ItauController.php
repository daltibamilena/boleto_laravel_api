<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class ItauController extends Controller
{
    private function digitoNossoNumero($agencia, $conta, $digito, $carteira, $id )
    {
        $laravelBoleto = new \Eduardokum\LaravelBoleto\CalculoDV;
        return $laravelBoleto->itauNossoNumero($agencia, $conta. '' .$digito, $carteira, $id);
    }

    private function formatDataBoleto($request) {
        $beneficiario = new \Eduardokum\LaravelBoleto\Pessoa([
        'documento' => $request->beneficiario["documento"],
        'nome'      => $request->beneficiario["nome"],
        'cep'       => $request->beneficiario["numero_CEP"],
        'endereco'  => $request->beneficiario["nome_logradouro"],
        'bairro'    => $request->beneficiario["nome_bairro"],
        'uf'        => $request->beneficiario["sigla_UF"],
        'cidade'    => $request->beneficiario["nome_cidade"],
        'numero'    => $request->beneficiario["numero"],
        ]);

        $pagador = new \Eduardokum\LaravelBoleto\Pessoa([
        'documento' => $request->pagador["documento"],
        'nome'      => $request->pagador["nome"],
        'cep'       => $request->pagador["numero_CEP"],
        'endereco'  => $request->pagador["nome_logradouro"],
        'bairro'    => $request->pagador["nome_bairro"],
        'uf'        => $request->pagador["sigla_UF"],
        'cidade'    => $request->pagador["nome_cidade"],
        ]);

        $itau = new \Eduardokum\LaravelBoleto\Boleto\Banco\Itau([
            'logo'                      => resource_path() . '/images/' . $request->beneficiario['logo'],
            'dataVencimento'            => Carbon::createFromFormat('Y-m-d', $request->boleto['data_vencimento']),
            'valor'                     => $request->boleto['valor_titulo'],
            'numero'                    => $request->boleto['numero_nosso_numero'] . "-" . $this->digitoNossoNumero($request->beneficiario["agencia"], $request->beneficiario["conta"], $request->beneficiario["digito"],$request->beneficiario["carteira"],$request->boleto['numero_nosso_numero']),
            'numeroDocumento'           => $request->boleto['numero_nosso_numero'],
            'pagador'                   => $pagador,
            'beneficiario'              => $beneficiario,
            'carteira'                  => $request->beneficiario["carteira"],
            'agencia'                   => $request->beneficiario["agencia"],
            'conta'                     => $request->beneficiario["conta"],
            'multa'                     => $request->boleto["multa"],
            'juros'                     => $request->boleto["juros"],
            'descricaoDemonstrativo'    => $request->boleto["demonstrativo"],
            'instrucoes'                => $request->boleto["instrucoes"],
        ]);

        return $itau;
    }

    public function generateBoletoHtml(Request $request)
    {
        return $this->formatDataBoleto($request)->renderHTML(true);
    }

    public function generateBoletoPdf(Request $request)
    {
        return $this->formatDataBoleto($request)->renderPDF(true);
    }
}
