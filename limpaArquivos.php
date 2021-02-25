<?php

$path = "tmp/";

$diretorio = dir($path);

while ($arquivo = $diretorio->read()) {
    if (date('Y-m-d', filemtime($path . $arquivo)) < date('Y-m-d')) {
        if (file_exists($path . $arquivo)) {
            unlink($path . $arquivo);
        }
    }
}
$diretorio->close();
