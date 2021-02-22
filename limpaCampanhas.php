<?php
/**
 * limpaCampanhas.php
 * Script para limpar tabela de broadcasts anteriores a data atual do banco
 */

//seleciona os Databases
$dbs = getSelectBanco();

//chama a função para percorrer por todos os Databases selecionados
listDbs($dbs);

/**
 * Função percorrer por todos os bancos do parametro $dbs
 * Esta percorre os bancos e chama a função para deltar os broadcasts
 * @param array $dbs - array contendo os Databases que devem ser conectados para deletar os broadcasts
 */
function listDbs($dbs)
{
    foreach ($dbs as  $value) {
        //conexão com o Database 
        $conn = getConn($value);

        //deleta os broadcasts
        delMessageText($conn);
    }
}

/**
 * Função para deletar todos broadcasts com data anterior a atual
 */
function delMessageText($conn)
{
    $query = "DELETE FROM tb_broadcast_send WHERE `data` < CURRENT_DATE;";
    return mysqli_query($conn, $query);
}

/**
 * Função para selecionar os Databases
 */
function getSelectBanco()
{
    $db = array();

    $conn = getConn('talkall_admin');
    $query = "SELECT banco FROM tb_empresa;";
    $st = mysqli_query($conn, $query);
    if (mysqli_num_rows($st) > 0) {
        while ($row = mysqli_fetch_row($st)) {
            $db[] = $row[0];
        }
    }
    return $db;
}

/**
 * seleciona a conexao do banco
 */
function getConn($banco)
{
    $conn = mysqli_connect('192.168.129.246', 'root', 'Db.T4lk#d35', "$banco", 3306);
    if (mysqli_connect_errno()) die(mysqli_connect_error());
    return $conn;
}