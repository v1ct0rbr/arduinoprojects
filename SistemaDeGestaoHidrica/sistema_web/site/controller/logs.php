<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if ($_GET['apagar_arquivo']) {
    foreach ($_GET as $key => $valor) {
        $$key = protecaoCampoFormulario2($valor);
    }
    if (is_null($ano_log) || !is_numeric($ano_log)) {
        $json['messages']['error'][] = "erro: O ano deve ser um valor numérico não nulo";
    }

    if (is_null($mes_log) || !is_numeric($mes_log)) {
        $json['messages']['error'][] = "erro: O mes deve ser um valor numérico não nulo";
    }
    if (!$json['messages']['error']) {
        $dados = "DATALOGS/$ano_log" . "/" . "$mes_log" . ".TXT";
        $resp = sendBySocket(APAGAR_LOG, $dados);
        echo $resp;
    } else {
        foreach ($json['messages']['error'] as $key => $value) {
            echo $value;
        }
    }
    echo json_encode($json);
    exit;
}
if ($_POST) {
//    $log_por_data = array();
    $array_json = array();
    foreach ($_POST as $key => $valor) {
        $$key = protecaoCampoFormulario2($valor);
    }

    if (is_null($ano_log) || !is_numeric($ano_log)) {
        $json['messages']['error'][] = "O ano deve ser um valor numérico não nulo";
    }

    if (is_null($mes_log) || !is_numeric($mes_log)) {
        $json['messages']['error'][] = "O mes deve ser um valor numérico não nulo";
    }
    if (!$json['messages']['error']) {
        $dados = "DATALOGS/$ano_log" . "/" . "$mes_log" . ".TXT";
        $log = sendBySocket2(RETORNA_LOG, $dados, true);
        $litros_gastos = totalLitrosFromLog($log);
        $result = "<b>TOTAL DE LITROS GASTOS:</b> ~" . $litros_gastos['total'] . " litros";
        $result .= "<hr />";
        $result .= str_replace("\n", "<br />", $log);

        $array_json['result'] = $result;
        $array_json['logdata'] = $litros_gastos;

        echo json_encode($array_json);
        exit;
    }
    echo json_encode($json);
    exit;
}




$anos = array();
$ano_atual = date("Y");
$mes_atual = date("m");

for ($i = ano_1; $i <= $ano_atual; $i++) {
    $anos[] = $i;
}
$smarty->assign("ano_atual", $ano_atual);
$smarty->assign("mes_atual", $mes_atual);
$smarty->assign("anos", $anos);

$smarty->display("logs.tpl");

function totalLitrosFromLog($log) {
//    $litros = 0;
    $logs_temp = str_replace("[", "", $log);
    $logs_final = explode("]", $logs_temp);
    $logdata = array();
    $logdata['total'] = 0;

    foreach ($logs_final as $value) {
        $array_log = explode(";", $value);
        $pos = strrpos("Desligada", $array_log[1]);
        if ($pos === false) {
            continue;
        } elseif ($array_log[2] != null && is_numeric($array_log[2])) {
            $dia_atual = substr($array_log[0], 10, 2);
            $logdata['total'] += $array_log[2];
            $logdata['por_data'][$dia_atual] += $array_log[2];
        }
    }


    return $logdata;
}
