<?php
$path = "tmp/";
$diretorio = dir($path);

while ($arquivo = $diretorio->read()) {
    // echo "<a href='" . $path . $arquivo . "'>" . $arquivo .  '</b> foi modificado em ' . date('Y-m-d H:i:s.', filemtime($path . $arquivo)) . "</a><br />";
    if (date('Y-m-d', filemtime($path . $arquivo)) < date('Y-m-d')) {
        if (file_exists($path . $arquivo)) {
            unlink($path . $arquivo);
        }
    }
}
$diretorio->close();
