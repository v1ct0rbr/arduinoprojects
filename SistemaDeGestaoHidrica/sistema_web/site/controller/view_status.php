<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$comando = fGet('comando');

if (isset($comando)) {

    switch ($comando) {
        case "view_status":
            $resp = sendBySocket("#S", "", 1024);
            break;
        case "view_config":
            $resp = sendBySocket("#C", "", 1024);
            break;
        default:
            $resp = "comando incorreto";
            break;
    }
    echo $resp;
}

//socket_write($sock,'UL#',3); //Requisita o status do sistema.
//$ultima_vez_desligado = socket_read($sock,20);