<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$resp = sendBySocket("#S", "", 1024);
$valores = json_decode($resp);

foreach ($valores as $key => $value) {
    $smarty->assign($key, $value);
}


$smarty->display("home.tpl");

