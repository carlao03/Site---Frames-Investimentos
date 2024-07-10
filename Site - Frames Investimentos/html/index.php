<?php
$formulario = file_get_contents("cotacao_dolar.html"); //busca o conteudo do arquivo e guarda na variavel

$cotacaoDia = array();
if (file_exists('contacao.json')){
  $conteudo = file_get_contents('cotacao.json');
  $cotacaoDia = json_decode($conteudo, true);
}

if (isset($_REQUEST['bPesquisar'])){
 $real = $_REQUEST['real']; //GUARDOU O CEP DO FORM
 $curl = curl_init(); // inicia atraves dessa funcao
 curl_setopt_array($curl, [CURLOPT_RETURNTRANSFER => 1, CURLOPT_URL => "https://economia.awesomeapi.com.br/json/last/USD-BRL"]);

 $resposta = curl_exec($curl);
 curl_close($curl);
 
 //transformar a resposta em um array
 $dados = json_decode($resposta, true);
 $vrDolar = 0;
 $vrTotal = 0;
 if (isset($dados["USDBRL"])){
   $vrDolar = $dados["USDBRL"]["high"];
   $vrTotal = $real / $vrDolar;
   $vrTotal = number_format($vrTotal, 2, ',','.');
   $cotacao = "<h2>US$ Total = $vrTotal<br>";
   $cotacao = $cotacao . "(usado vr.dólar = $vrDolar)</h2>";
 }
 else{
    $cotacao = "<h2>Não foi possível fazer a cotação.</h2>";
 }
 $formulario = str_replace("<!--DADOS-->", $cotacao, $formulario);
 
}

echo $formulario;

?>