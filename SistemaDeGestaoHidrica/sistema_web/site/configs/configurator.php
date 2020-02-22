<?php

/* * *********************************************************** */
/* * *********** Arquivo de Configuração dos Sistemas ********** */
/* * ************ Desenvolvido por Victor Queiroga ************* */
/* * *********************************************************** */


#**********=====Deve ser Mudado no servidor=====************
//define("type_server", "remote");
////////////////////////////////////////////////////////////
define("bd_servidor", "localhost");
define("bd_charset", "UTF-8");
define("table_prefix", "pp_");

define("HASH_CONN", "59412c16dee710cd7be629726a908732ccff4d5c11bc2aa7c30c2c7e7825c184");
define("IP_CONTROLE_BOMBA", "192.168.137.2");
define("PORTA_SOCKET", 8081);

////////////////COMANDOS ARDUINO//////////////////
define("VERIFICA_LOGIN", "!V");
define("RETORNA_LOG", "&L");
define("APAGAR_LOG", "&X");

//////////////////////////////////

define("ano_1", 2016);
define("colate", "COLLATE utf8_general_ci");
define("fisico_relativo", "");
//define("fisico", dirname(__FILE__));
//==========================================================
define("MAX_THUMBS_WIDTH", 230);
define("MAX_THUMBS_HEIGHT", 153);
define("lingua_pt", "pt");
define("lingua_en", "en");
define("lingua_fr", "fr");
define("site", minhaurl);
define("site_cliente", minhaurl . "/cliente");
define("site_admin", minhaurl . "/admin");
define("fisico_site", fisico);
define("fisico_admin", fisico_site . "/admin");
define("fisico_cliente", fisico_site . "/cliente");
define("fisico_site_relativo", "");
define("fisico_admin_relativo", fisico_site_relativo . "/admin");
define("fisico_cliente_relativo", fisico_site_relativo . "/cliente");
define("configuracao", fisico_site . "/configs");
define("configuracao_relativo", "/configs");
define("controller", fisico_site . "/controller");
define("controlleradmin", fisico_admin . "/controller");
define("controllercliente", fisico_cliente . "/controller");
define("arquivos", site . "/arquivos");
define("arquivos_fisico", fisico_site . "/arquivos");
define("arquivos_portfolio", arquivos_fisico . "/portfolio");
define("imagens_site", site . "/assets/img");
define("imagens_admin", site_admin . "/img");
define("images_upload", arquivos . "/upload/noticias");
define("classes", fisico_site . "/model");
define("dao", fisico_site . "/dao");
define("includes", fisico_site . "/includes");
define("includes_cliente", fisico_cliente . "/includes");
define("includes_admin", fisico_admin . "/includes");
define("css", "assets/css");
define("css_admin", "css");
define("js", "assets/js");
define("js_admin", "js");
define("imagem_noticia", site . "/arquivos/noticias/");
define("imagem_noticia_fisico", fisico . "/arquivos/noticias/");
define("libs", site . "/bibliotecas");
define("libs_fisico", fisico_site . "/bibliotecas");
define("tempo_maximo_sessao", 1500);
define("email_cobranca", "");
/* =========================================================== */

define("google_api_key", "AIzaSyDegeoIlbYdyNYcnYUseFgcAo3Con7SNhw");
//localhost
//define("public_google_key", "6Lcr5AETAAAAAIs7OTUSAn8QmHDUwkvZkGZT_fyW");
//define("private_google_key", "6Lcr5AETAAAAABIoF91lfQzihc9Fv1If_KS0BDCw");
//botero
//define("public_google_key", "6LeRRP4SAAAAAMA-rHSZonLX1bj6B9H2C8Ban9bu");
//define("private_google_key", "6LeRRP4SAAAAALOPF0DVkZ4ts6cWwX_rUxx5XIEA");
//vivasoft
define("public_google_key", "6LdYk-4SAAAAADpNbvLsq8ejOWorSz6o-hJn9K1o");
define("private_google_key", "6LdYk-4SAAAAAIj-RKjg_W1eVGgD-HTuz6sA048-");

define("extensao", "");

define("large_width", 618);
define("large_height", 246);
define("max_pages", 8);

define("palavra_passe", "@grupoTiFpb@");
define("sistema_habilitado", true);
define("key_gmap", "AIzaSyA8V1rk8bBVohoXleOY6Nl6YYyQlXNYblA");
define("idioma_padrao", "pt_BR");
$linguas = array('BR', 'EN');
//=============facebook===================
define("appId", "227875244035572");
define("appSecret", "8f26e84a5271782f7320194e750a5b52");
?>
