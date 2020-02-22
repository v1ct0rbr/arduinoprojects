<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$comando = fGet('do');

if (isset($comando)) {
    $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    socket_set_option(
            $sock, SOL_SOCKET, // socket level
            SO_SNDTIMEO, // timeout option
            array(
        "sec" => 10, // Timeout in seconds
        "usec" => 0  // I assume timeout in microseconds
            )
    );
    if (socket_connect($sock, IP_CONTROLE_BOMBA, PORTA_SOCKET)) {
        switch ($comando) {
            case "desligar":
                socket_write($sock, "#D", 2); //Requisita o status do sistema.
                break;
            case "ligar":
                socket_write($sock, "#L", 2); //Requisita o status do sistema.
                break;
//            case "ligar_switch_automatico":
//                socket_write($sock, "#S", 2); //Requisita o status do sistema.    
//                break;
//            case "desligar_switch_automatico":
//                socket_write($sock, "#N", 2); //Requisita o status do sistema.        
//                break;
            case "view_status":
                socket_write($sock, "#S", 2); //Requisita o status do sistema.        
                break;
            case "pump_config":
                socket_write($sock, "#C", 2); //vê configurações da bomba.        
                break;
            default:
                break;
        }
        $resp = socket_read($sock, 100);
        socket_close($sock);
        echo $resp;
    } else {
        echo "erro na conexao";
    }
}