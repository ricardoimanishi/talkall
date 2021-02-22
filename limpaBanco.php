<?php

//seleciona os Databases
$dbs = getSelectBanco();

//chama a função para deletar as mensagens
getMessagensDb($dbs);

/**
 * Função para deletar as mensagens com data maior que 6 meses
 * Esta função deleta as mensagens com mais de 6 meses
 * @param array $dbs - array contendo os Databases que devem ser conectados para deletar as mensagens
 */
function getMessagensDb($dbs)
{
    foreach ($dbs as  $value) {
        //conexão com o Database 
        $conn = getConn($value);

        //deleta as mensagens de texto
        delMessageText($conn);

        //seleciona as mensagens com anexos para deletar
        $query = "SELECT
                    id_message,
                    media_url 
                FROM
                    messages 
                WHERE
                    media_type IN (2,3,4,5,6,7,9,10,26)
                    AND creation >= UNIX_TIMESTAMP( NOW( ) - INTERVAL 6 MONTH )";
        $st = mysqli_query($conn, $query);
        if (mysqli_num_rows($st) > 0) {
            while ($row = mysqli_fetch_row($st)) {
                //deleta o arquivo vinculado ao registro
                if ($row[1]) {
                    delFile($row[1]);
                }

                //deleta a mensagem
                delMessage($conn, $row[0]);
            }
        }
    }
}

/**
 * Função para deletar a mensagem pelo id_message
 */
function delMessage($conn, $id_message)
{
    $query = "DELETE FROM messages WHERE id_message = $id_message;";
    return mysqli_query($conn, $query);
}

/**
 * Função para deletar todas as mensagens de texto com mais de 6 meses
 */
function delMessageText($conn)
{
    $query = "DELETE FROM messages WHERE status = 1 AND creation < UNIX_TIMESTAMP( NOW( ) - INTERVAL 6 MONTH );";
    return mysqli_query($conn, $query);
}

/**
 * Função para deletar arquivo
 */
function delFile($arquivo)
{
    $nomeArquivo = getName($arquivo);
    $dir = "./files/";
    if (file_exists($dir.$nomeArquivo)) {
        unlink($dir.$nomeArquivo);
    }
}

/**
 * Função para selecionar os Databases
 */
function getSelectBanco()
{
    $db = array();

    $conn = getConn('talkall_admin');
    $query = "SELECT db FROM company;";
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
    $conn = mysqli_connect('192.168.129.244', 'root', 'Db.T4lk#d35', "$banco", 3306);
    // $conn = mysqli_connect('localhost', 'root', 'Db.T4lk#d35', "$banco");
    if (mysqli_connect_errno()) die(mysqli_connect_error());
    return $conn;
}

/**
 * seleciona somente o nome do arquivo
 */
function getName($nome)
{
    $nome = explode('/', $nome);
    return end($nome);
}
