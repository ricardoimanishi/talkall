<?php
$cep = $_REQUEST['cep'];

$lojas = getDadosLojas();

$endereco_origem = getEnderecoCep($cep);

$dados_distance = getDistanceLojas($endereco_origem, $lojas);

$cod_min = getMenorDistance($dados_distance);

echo mensagem($lojas, $dados_distance, $cod_min);

/**
 * seleciona a conexao do banco
 */
function getConn()
{
    $conn = mysqli_connect('localhost', 'root', '', "talkall", 3306); #alterar dados de conexão
    if (mysqli_connect_errno()) die(mysqli_connect_error());
    return $conn;
}

/**
 * Função para capturar os dados das lojas
 */
function getDadosLojas()
{
    $dados = [];
    $conn = getConn();
    //seleciona as mensagens com anexos para deletar
    $query = "SELECT cod, nome, logradouro, bairro, numero, localidade, uf, cep FROM lojas";
    $st = mysqli_query($conn, $query);
    if (mysqli_num_rows($st) > 0) {
        while ($row = mysqli_fetch_row($st)) {
            $dados[$row[0]] =  ["nome" => $row[1], "logradouro" => $row[2], "bairro" => $row[3], "numero" => $row[4], "localidade" => $row[5], "uf" => $row[6], "cep" => $row[7]];
        }
    }
    return $dados;
}

/**
 * Função para consultar o endereço por CEP
 */
function getEnderecoCep($cep)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://viacep.com.br/ws/$cep/json/",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    return $response;
}

/**
 * Função para calcular as distancias de todas as lojas
 */
function getDistanceLojas($endereco_origem, $lojas)
{
    $distancias = [];
    foreach ($lojas as $key => $loja) {
        $destinations = urlencode($loja['logradouro'] . ", " . $loja['numero'] . ", " . $loja['localidade'] . ", " . $loja['uf']);
        $dados = getDistance(formataEndereco($endereco_origem), $destinations);
        $dado = json_decode($dados);
        if ($dado->status == "OK") {
            $distancias[$key] =  $dado->rows[0]->elements[0]->distance->value;
        }
    }
    return $distancias;
}

/**
 * Função para formatar o endereço
 */
function formataEndereco($dados)
{
    $dados = json_decode($dados);
    return urlencode("$dados->logradouro, $dados->bairro, $dados->localidade, $dados->uf");
}

/**
 * Função para calcular a distancia entre endereços
 */
function getDistance($origins, $destinations)
{
    //chave google
    $key = "AIzaSyDxsmEBS_FzZHq4p5QeGBXMxqHcavkw7n8"; #alterar chave do google
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://maps.googleapis.com/maps/api/distancematrix/json?origins=$origins&destinations=$destinations&key=$key",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;
}

/**
 * Função para capturar o codigo da loja mais proxima do cep informado
 */
function getMenorDistance($player_score_totals)
{
    // data
    $min_keys = array();
    // search for array keys with min() value
    foreach ($player_score_totals as $playerid => $score)
        if ($score == min($player_score_totals)) array_push($min_keys, $playerid);

    return $min_keys[0];
}

/**
 * Função que retorna a mensagem pro bot
 */
function mensagem($lojas, $dados_distance, $cod_min)
{
    $distancia_km = round($dados_distance[$cod_min]/1000,1);
    return "A loja mais próxima do cep informado fica a " . $distancia_km . "km, " . $lojas[$cod_min]['nome'] . " localizada na " . $lojas[$cod_min]['logradouro'] . ", bairro " . $lojas[$cod_min]['bairro'] . ", " . $lojas[$cod_min]['numero'] . ", " . $lojas[$cod_min]['localidade'] . "/" . $lojas[$cod_min]['uf'];
}

