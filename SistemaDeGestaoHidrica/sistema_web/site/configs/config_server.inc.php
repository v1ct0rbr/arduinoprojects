<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//Deve ser mudado no servidor
define("type_server", "local");
///////////////////////////////////////
define("fisico", "$_SERVER[DOCUMENT_ROOT]bombadagua");

switch (type_server) {
    case 'local':
        require fisico . '/configs/config_server_local.php';
        break;
    case 'remote':
        require fisico . '/configs/config_server_remote.php';
        break;
}