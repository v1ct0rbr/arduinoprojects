<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (protecaoCampoFormulario2(fGet('sair')) == 'true') {
    if ($_SESSION['dados_sessao'] != null) {
        $resp = sendBySocket(VERIFICA_LOGIN);
        if ($_SESSION['dados_sessao']['login'] == $resp) {
            sendBySocket("#X", "", 0, false);
            $_SESSION['dados_sessao'] = null;
        } else {
            $_SESSION['dados_sessao'] = null;
        }
    }
    header("location: " . site . "/login!loggedout!true");
    exit;
}

if ($_POST) {
    //inclusão das classes
    //instanciação dos objetos
    foreach ($_POST as $key => $valor) {
        $$key = protecaoCampoFormulario2($valor);
        if ($key == 'senha')
            continue;
        $smarty->assign($key, $valor);
    }

    $senha = protecaoCampoFormulario2(fPost('senha'));

    if ($login == null || $login == "") {
        $json['messages']['error'][] = 'O Login deve ser informado.';
    }
    if ($senha == null || $senha == "") {
        $json['messages']['error'][] = "A senha deve ser informada.";
    }

    if (!$json['messages']['error']) {
        $_usuario->setUsu_login($login);
        $_usuario->setUsu_Password(encryptPassword($senha));
        $dado = $_usuario->login();

        if (!empty($dado)) {
//            session_regenerate_id();
            $dados = array(
                "login" => $dado['login'],
                "senha" => $dado['senha'],
                "codigo" => $dado['codigo'],
                "session_id" => $dado['token_sessao'],
                "logado_em" => time()
            );

            $resp = sendBySocket("!A" . ";" . $dados['login'] . ";" . $dados['senha'] . ";" . HASH_CONN);
            $pos = strrpos($resp, "true");
            if ($pos === false) {
                $json['messages']['erro'][] = "Arduino não aceitou o login ($resp)";
            } else {
                $dados['log_data'] = $dados['logado_em'];
                $_SESSION['dados_sessao'] = $dados;
                $json['messages']['success'][] = "Login bem sucedido. Você está logado no dispositivo";
            }
//            $json['messages']['success'][] = "Login bem sucedido. Entrando no sistema.... ";
        } else {
            $json['messages']['error'][] = "Login inexistente ou inválido. ";
        }
    }


    echo json_encode($json);
    exit;
}
$smarty->display("login.tpl");
