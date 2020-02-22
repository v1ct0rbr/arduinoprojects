<?php

/* * *********************************************************** */
/* * ************** FrontControler dos Sistemas ****************** */
/* * ************ Desenvolvido por Victor Queiroga ************** */
/* * *********************************************************** */

session_cache_expire(30);
//$cache_expire = session_cache_expire();
ob_start();
session_start();
//session_destroy();
//@date_default_timezone_set("America/Recife");
//header('Content-type: text/html; charset=UTF-8');
// Turn off error reporting
error_reporting(0);
// Report runtime errors
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
//header("Content-Type: text/html;  charset=UTF-8", true);
// Configurações do sistema
$charset = "UTF-8";

require("configs/empresa.php");
include_once ('configs/config_server.inc.php');

require("configs/configurator.php");
require("configs/paginas.php");
require_once libs_fisico . '/php-gettext-1.0.11/gettext.php';
require_once libs_fisico . '/php-gettext-1.0.11/streams.php';
//Antigo =======require_once ("bibliotecas/Smarty.class.php");========
define('SMARTY_RESOURCE_CHAR_SET', $charset);
define('SMARTY_DIR', './bibliotecas/Smarty-3.1.21/libs/');
ini_set('include_path', SMARTY_DIR);
set_include_path(SMARTY_DIR);
if (function_exists('mb_internal_encoding')) {
    mb_internal_encoding('UTF-8');
}
//echo 'teste';
//exit;
require_once (SMARTY_DIR . "Smarty.class.php");

$messages = array();
$json = array();

require(classes . "/BD.php");
require("utils/funcoes.php");
require (classes . "/usuario.classes.php");
require (dao . '/UsuarioDao.php');
$messages = array();
$json = array();


$_usuario = new UsuarioDao();
$ip = $_SERVER['REMOTE_ADDR'];


$directory = 'locale';
$domain = 'messages';
$locale = idioma_padrao;
$lang = lingua_pt;
//add later -> lingua_fr => "fr_FR"
$languages = array(lingua_pt => "pt_BR", lingua_en => "en_US", lingua_fr => "fr_FR");

if (isset($_GET['gl'])) {
    $lang = protecaoCampoFormulario2($_GET['gl']);
    if (array_key_exists($lang, $languages)) {
        $locale = $languages[$lang];
    }
} elseif (isset($_COOKIE['traducao'])) {
    $lang = protecaoCampoFormulario2($_COOKIE['traducao']);
    if (array_key_exists($lang, $languages)) {
        $locale = $languages[$lang];
    }
} else {
    $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    if (array_key_exists($lang, $languages)) {
        switch ($lang) {
            case lingua_pt:
                $locale = $languages[lingua_pt];
                break;
            case lingua_en:
                $locale = $languages[lingua_en];
                break;
            case lingua_fr:
                $locale = $languages[lingua_fr];
                break;
            default:
                $locale = idioma_padrao;
                break;
        }
    } else {
        $lang = lingua_pt;
        $locale = idioma_padrao;
    }
}
if (is_null($lang) || trim($lang) == "" || !array_key_exists($lang, $languages)) {
    $lang = lingua_pt;
    $locale = idioma_padrao;
}

$localeFile = new FileReader("locale/$locale/LC_MESSAGES/messages.mo");
$localeFetch = new gettext_reader($localeFile);
setcookie("traducao", "");
setcookie("traducao", $lang, time() + 60 * 60 * 24 * 30);
setlocale(LC_ALL, null);
setlocale(LC_ALL, $locale);
//setlocale(LC_NUMERIC, 'C');
textdomain(null);

textdomain($domain);
putenv("LANG=" . $locale);



$smarty = new Smarty;
$smarty->setPluginsDir(SMARTY_DIR . "/plugins/");
$smarty->setTemplateDir(fisico . '/view/');
$smarty->setCompileDir(fisico . '/view_c/');
$smarty->setConfigDir(fisico . '/configs/');
$smarty->setCacheDir(fisico . '/cache/');
$smarty->caching = false;

$smarty->assign("locale", $locale);
$smarty->assign("languages", $languages);
$smarty->assign("_URLSITE", site);
$smarty->assign("_URLADMIN", site_admin);
$smarty->assign("_DOMAIN", minhaurl);
$smarty->assign("_FISICO_RELATIVO", fisico_relativo);
$smarty->assign("_IMG", imagens_site);
$smarty->assign("_IMG_SITE", "images");
$smarty->assign("_ARQ", arquivos);
$smarty->assign("_JS", "assets/js");
$smarty->assign("_JS_SITE", 'js');
$smarty->assign("_PLUGINS", 'plugins');
$smarty->assign("_CSS", "assets/css");
$smarty->assign("_CSS_SITE", "css");
$smarty->assign("_LIBS", 'bibliotecas');
$smarty->assign("_INCLUDES", includes);
$smarty->assign("_EX", extensao);
$smarty->assign("_fone1", empresa_fone1);
$smarty->assign("_fone2", empresa_fone2);
$smarty->assign("_fone3", empresa_fone3);



/// ======TRADUÇÕES=======
//traducao_smarty("about_localization");
$publickey = public_google_key;
$smarty->assign("public_google_key", $publickey);
$privatekey = private_google_key;
$smarty->assign("lang", $locale);

if (array_key_exists('HTTP_USER_AGENT', $_SESSION)) {
    if ($_SESSION['HTTP_USER_AGENT'] !=
            md5($_SERVER['HTTP_USER_AGENT'])) {
        /* Acesso inválido. O header User-Agent mudou
          durante a mesma sessão. */
        echo 'Erro: O header User-Agent mudou';
        exit;
    }
} else {
    /* Primeiro acesso do usuário, vamos gravar na sessão um
      hash md5 do header User-Agent */
    $_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
}

if (!isset($_GET['pg'])) {
    $_GET['pg'] = 'home';
}

if ($_GET['pg'] != 'login') {
//    if (!is_null($_GET['ajax_request']) && is_numeric($_GET['ajax_request']) && $_GET['ajax_request'] == 1) {
//        if (!verificaUsuarioLogado()) {
//            echo 'usuario_nao_logado';
//        } elseif (!verificaSessaoExpirada()) {
//            echo 'fim_de_sessao';
//        } else {
//            echo 'ok';
//        }
//        exit;
//    } else {
        if (!verificaUsuarioLogado()) {
            header("location: " . 'login' . extensao . '!back_url!' . $_GET['pg'] . "&autenticacao=1");
            exit;
        }
        if (!verificaSessaoExpirada()) {
            header("location: " . site . '/login' . extensao . '!back_url!' . $_GET['pg'] . "&expirado=1");
            exit;
        }
//    }
}


$paginas_desabilitadas = array();
if (isset($_GET['pg'])) {
    if (array_key_exists($_GET['pg'], $paginas_desabilitadas)) {
        echo 'Página temporariamente indisponível. <input type="button" value="voltar" onclick="window.history.back()" />';
        exit;
    }
    if ($_GET['pg'] == 'manutencao')
        $controller = "home";
    if ($_GET['pg'] == 'feed-rss2')
        $controller = '/feed/' . $_GET['pg'];
    else {
        $controller = $_GET['pg'];
    }
} else {
    $controller = "home";
}

//echo controller . "/" . $controller . ".php"; exit;
if (!file_exists(controller . "/" . $controller . ".php")) {
//    header("HTTP/1.0 404 Não Encontrado");
//    header("HTTP/1.0 404 Not Found");
    header("Location:" . site . extensao . "/erro,404");
} else {
    include controller . "/" . $controller . ".php";
}

//include controller."/".'manutencao';
?>

