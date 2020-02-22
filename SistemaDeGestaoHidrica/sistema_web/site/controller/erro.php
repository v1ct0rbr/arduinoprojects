<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


if (isset($_GET['q']) && is_numeric($_GET['q'])) {
    $erro = protecaoCampoFormulario2($_GET['q']);
    switch ($erro) {
        case "404":
            $smarty->assign("erro", "404");
            $smarty->assign("titulo", "Página não encontrada");
            $smarty->assign("detalhes", 'Desculpe, mas a página que você está procurando não existe ou foi removida. '
                    . 'Por favor, volte a página inicial <a href="' . site . extensao . '">Homepage</a> ou procure novamente.');
            break;
        case "403":
            $smarty->assign("erro", "403");
            $smarty->assign("titulo", "Você não tem permissão");
            $smarty->assign("detalhes", 'Desculpe, mas você não tem permissão para acessar desejada. '
                    . 'Por favor, volte a página inicial <a href="' . site . extensao . '">Homepage</a>.');
            break;
        default:
            $smarty->assign("erro", "Desconhecido");
            $smarty->assign("titulo", "Erro desconhecido");
            $smarty->assign("detalhes", 'Desculpe, mas você não tem permissão para acessar desejada. '
                    . 'Por favor, volte a página inicial <a href="' . site . extensao . '">Homepage</a>.');
            break;
    }
} else {
    $smarty->assign("erro", "Desconhecido");
    $smarty->assign("titulo", "Erro Desconhecido");
    $smarty->assign("detalhes", 'Desculpe, mas a página que você está procurando não existe ou foi removida. '
            . 'Por favor, volte a página inicial <a href="' . site . extensao . '">Homepage</a> ou procure novamente.');
}

$smarty->display("erro.tpl");
