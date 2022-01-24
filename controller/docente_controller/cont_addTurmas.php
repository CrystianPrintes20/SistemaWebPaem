<?php
session_start();

if(isset($_POST['Discente']))
{
    $discentes = $_POST['Discente'];

    $cont = 0;
    foreach ($discentes as &$value) {
        $cont += 1;
        echo "
        <tr>
            <td>$cont</td>
            <td>$value[nome]</td>
            <td><span>$value[matricula]</span></td>
        </tr>
    ";
    } 
}
?> 