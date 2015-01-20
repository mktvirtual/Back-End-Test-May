<?php
$sizeErros = sizeof(@$erros);
if ($sizeErros > 0) {
    echo "<ul class='save_erros'>";
    echo "<li><strong>ERRO</strong></li>";
    foreach ($erros as $campo => $err) {
        echo "<li>". $err ."</li>";
    }
    echo "</ul>";
} elseif (sizeof(@$ok) > 0) {
    echo "<ul class='save_ok'>";
    echo "<li><strong>OK</strong></li>";
    foreach ($ok as $campo => $err) {
        echo "<li>$err</li>";
    }
    echo "</ul>";
}
