<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
define("DEFAULT_TIMEZONE", 3);

if (isset($_GET["switch_pump"])) {
    $valor_switch = fGet('switch_pump');
//    $json['messages']['error'][] = $valor_switch;

    if ($valor_switch == "true") {
        $resp = sendBySocket("#L");
        if ($resp != "true") {
            $json['messages']['warning'][] = "erro ao ligar bomba";
        }
    } else {
        $resp = sendBySocket("#D");
        if ($resp != "true") {
            $json['messages']['error'][] = "erro ao desligar bomba";
        }
    }
    echo json_encode($json);
    exit;
}

if (isset($_POST["configuracoes_gerais"]) && fPost("configuracoes_gerais") == true) {
    foreach ($_POST as $key => $valor) {
        $$key = protecaoCampoFormulario2($valor);
    }
    if ($timezone == null) {
        $timezone = DEFAULT_TIMEZONE;
    } elseif (!is_numeric($timezone) || $timezone > 12 || $timezone < -12) {
        $json['messages']['error'][] = "Timezene deve ter valor entre -12 e 12";
    }

    if (!$json['messages']['error']) {
        $parametros = "&G[TIMEZONE=$timezone] // Distancia do sensor em relacao ao topo da caixa\n" .
                "[HASH_CONN=" . HASH_CONN . "] // Distancia do sensor em relacao ao topo da caixa\n";
        $json['messages']['success'][] = sendBySocket("&G", $parametros);
    } elseif (!$json['messages']) {
        $json['messages']['warning'][] = "Nenhuma operação foi realizada.";
    }
    echo json_encode($json);
    exit;
}


if (isset($_POST["configuracoes_bomba"]) && fPost("configuracoes_bomba") == true) {

    foreach ($_POST as $key => $valor) {
        $$key = protecaoCampoFormulario2($valor);
    }

    if ($distancia_correcao == null) {
        $distancia_correcao = 0;
    } elseif (!is_numeric($distancia_correcao)) {
        $json['messages']['error'][] = "Se este campo não for nulo, o mesmo deve ser numérico";
    }

    if ($area_base == null || !is_numeric($area_base) || $area_base < 0) {
        $json['messages']['error'][] = "A área da base deve ser fornecida corretamente";
    }

    if ($altura == null || !is_numeric($altura) || $altura < 0) {
        $json['messages']['error'][] = "Forneça a altura corretamente";
    }

    if ($nivel_minimo == null || !is_numeric($nivel_minimo) || $nivel_minimo < 0) {
        $json['messages']['error'][] = "O nível mínimo da caixa dágua deve ser um valor não nulo e numérico ";
    }

    if ($nivel_maximo == null || !is_numeric($nivel_maximo) || $nivel_maximo < 0) {
        $json['messages']['error'][] = "O nível máximo da caixa dágua deve ser um valor não nulo e numérico ";
    }

    if ($vazao != null && (!is_numeric($vazao) || $vazao < 0)) {
        $json['messages']['error'][] = "Se vazão for não-nulo, o mesmo deve ser positivo e diferente de zero";
    }

    if ($tempo_espera == null || !is_numeric($tempo_espera) || $tempo_espera < 0) {
        $json['messages']['error'][] = "O nível máximo da caixa dágua deve ser um valor não nulo e numérico e maior que zero ";
    }

    if (!is_numeric($permitir_ligamento_automatico)) {
        $json['messages']['error'][] = "O campo de ligação automática deve ser numérico";
    }

    if (!$json['messages']['error']) {
        $distancia_correcao = str_replace(',', '.', $distancia_correcao);
        $area_base = str_replace(',', '.', $area_base);
        $altura = str_replace(',', '.', $altura);
        $nivel_minimo = str_replace(',', '.', $nivel_minimo);
        $nivel_maximo = str_replace(',', '.', $nivel_maximo);
        $tempo_espera = str_replace(',', '.', $tempo_espera);

        $parametros = "[DISTANCIA_CORRECAO=$distancia_correcao]\n" .
                "[AREA_BASE=$area_base]\n" .
                "[ALTURA=$altura]\n" .
                "[NIVEL_MINIMO=$nivel_minimo]\n" .
                "[NIVEL_MAXIMO=$nivel_maximo]\n" .
                "[VAZAO=$vazao]\n" .
                "[PERMITIRLIGAMENTOAUTOMATICO=$permitir_ligamento_automatico]\n" .
                "[TEMPO_ESPERA=$tempo_espera]\n";

        $json['messages']['success'][] = sendBySocket("&B", $parametros);
    } elseif (!$json['messages']) {
        $json['messages']['warning'][] = 'Nenhuma operação foi realizada';
    }
    echo json_encode($json);
    exit;
}

function definiParametrosGerais() {
    $valor = "&G[TIMEZONE=$timezone]";
    return $valor;
}

$resp = sendBySocket("#C", "", 512);
$pametros_bomba = json_decode($resp);

foreach ($pametros_bomba as $key => $value) {
    $smarty->assign($key, $value);
}

//$timezones[] = array("titulo" => "GMT - Greenwich Mean Time = UTC (0)", "valor" => 0);
//$timezones[] = array("titulo" => "GMT - Greenwich Mean Time = UTC (0)", "valor" => 0);
$timezones[] = array("titulo" => "DEFAULT (BRAZIL)", "valor" => 0);
$timezones[] = array("titulo" => "BST - British Summer Time", "valor" => 1);
$timezones[] = array("titulo" => "ADT - Atlantic Daylight Time(BRAZIL)", "valor" => -3);
$timezones[] = array("titulo" => "AST - Atlantic Standard Time (-4)", "valor" => -4);

$smarty->assign("timezones", $timezones);
//
$smarty->display("configuracao.tpl");
