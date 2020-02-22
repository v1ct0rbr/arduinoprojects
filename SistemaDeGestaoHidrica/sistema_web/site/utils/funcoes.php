<?php

function sendBySocket($comando, $dados = "", $tamanho = 100, $wait_response = true) {
    $resp = "sem resposta";
    $texto = $comando . ($_SESSION['dados_sessao'] != null ? ";" . $_SESSION['dados_sessao']["login"] . ";" . $_SESSION['dados_sessao']["senha"] . ";" . HASH_CONN : "") . ($dados != null && $dados != "" ? ";" . $dados : "");
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
        socket_write($sock, $texto, strlen($texto)); //Requisita o status do sistema.        
        if ($wait_response) {
            $resp = socket_read($sock, $tamanho);

//            $resp = socket_read($sock, $tamanho, PHP_NORMAL_READ);
        }
    }
    socket_close($sock);
    return $resp;
}

function sendBySocket2($comando, $dados = "", $wait_response = true) {
    $resp = "sem resposta";
    $texto = $comando . ($_SESSION['dados_sessao'] != null ? ";" . $_SESSION['dados_sessao']["login"] . ";" . $_SESSION['dados_sessao']["senha"] . ";" . HASH_CONN : "") . ($dados != null && $dados != "" ? ";" . $dados : "");
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
        socket_write($sock, $texto, strlen($texto)); //Requisita o status do sistema.        
        if ($wait_response) {
            $resp = "";
            while (($currentByte = socket_read($sock, 1)) != "") {
                // Do whatever you wish with the current byte
                $resp .= $currentByte;
            }
//            $resp = socket_read($sock, $tamanho, PHP_NORMAL_READ);
        }
    }
    socket_close($sock);
    return $resp;
}

function sync_usuario_dispositivo() {
    $resp = sendBySocket(VERIFICA_LOGIN);
    if ($_SESSION['dados_sessao']) {
        if ($resp == $_SESSION['dados_sessao']['login']) {
            return true;
        } else {
            $_SESSION['dados_sessao'] = null;
            return false;
        }
    }
    return false;
}

function fGet($get) {
    return filter_input(INPUT_GET, $get);
}

function fPost($post) {
    return filter_input(INPUT_POST, $post);
}

function fServer($server) {
    return filter_input(INPUT_SERVER, $server);
}

function isPasswordStrong($password) {
    if (!preg_match("/^(?=^.{6,}$)((?=.*[a-z0-9])(?=.*[a-z]))^.*$/", $password)) {
        return false;
    } else {
        return true;
    }
}

function traduzir($text) {
    global $localeFetch;
    return $localeFetch->translate($text);
}

function traduzirCaptcha() {
    global $smarty;
    $smarty->assign("reload_captcha", traduzir("reload_captcha"));
    $smarty->assign("listen_captcha", traduzir("listen_captcha"));
    $smarty->assign("change_for_image_captcha", traduzir("change_for_image_captcha"));
    $smarty->assign("insert_code", traduzir("insert_code"));
    $smarty->assign("insert_code_listened", traduzir("insert_code_listened"));
    $smarty->assign("listen_code_again", traduzir("listen_code_again"));
    $smarty->assign("download_sound_mp3", traduzir("download_sound_mp3"));
    $smarty->assign("incorrect_solution", traduzir("incorrect_solution"));
    $smarty->assign("help", traduzir("help"));
    $smarty->assign("fill_in_correctly", traduzir("fill_in_correctly"));
    $smarty->assign("captcha_not_empty", traduzir("captcha_not_empty"));
}

function traducao_smarty($value) {
    global $smarty;
    global $messages;
    try {
        $valor = traduzir($value);
        $smarty->assign($value, $valor);
    } catch (Exception $exc) {
        $messages['warning'][] = $exc->getTraceAsString();
    }
    return $valor;
}

function encryptPassword($password) {
    return hash("sha256", palavra_passe . hash("sha256", $password));
}

function verificaUsuarioLogado() {
    if ($_SESSION['dados_sessao']) {
        return true;
    } else {
        return false;
    }
}

function verificaSessaoExpirada() {
    $usuario = new UsuarioDao();
    $hora_atual = time();
    if ($_SESSION['dados_sessao'] != null) {
        if ($usuario->verificarSessionId($_SESSION['dados_sessao']['codigo']) != $_SESSION['dados_sessao']['session_id']) {
            sendBySocket("#X", "", 100, false);
            $_SESSION['dados_sessao'] = null;
            return false;
        } elseif (($hora_atual - $_SESSION['dados_sessao']['log_data']) <= tempo_maximo_sessao) {
            $_SESSION['dados_sessao']['log_data'] = time();
            return true;
        } else {
            sendBySocket("#X", "", 0, false);
            $_SESSION['dados_sessao'] = null;
            return false;
        }
    } else {
        return false;
    }
}

function verificaPermissao($pagina) {
    $permissoes = $_SESSION["usuario_logado"]['permissao'];
    foreach ($permissoes as $value) {
        if (substr_count($pagina, $value['permissao']) or $value['permissao'] == 'administrador')
            return true;
    }
    return false;
}

function verificaPermissao2($permissao, $permissao2 = null) {
//    require_once ("configuracao/configurator.php");
    global $config;
    $permissoes = $_SESSION["usuario_logado"]['permissao'];
    foreach ($permissoes as $key => $value) {
//        echo '   balbal -    key - ' . $value['codigo'] . '  - tudo:' .$config["permissoes"]["administrador"]. '<br /><br />';
//        print_r($value);
//
//        echo "$value[codigo]" . ' - ' . $config["permissoes"]["administrador"];

        if ($permissao2 != null) {
            if ($value['codigo'] == $config["permissoes"]["administrador"] || $value['codigo'] == $permissao || $value['codigo'] == $permissao2)
                return true;
        }
        else
        if ($value['codigo'] == $config["permissoes"]["administrador"] || $value['codigo'] == $permissao)
            return true;
    }
    return false;
}

function filterData($data) { //Filters data against security risks.
    $data = trim(htmlentities(strip_tags($data)));
    if (get_magic_quotes_gpc())
        $data = stripslashes($data);
    $data = mysql_real_escape_string($data);
    return $data;
}

function protecaoCampoFormulario($campo) {
    return htmlspecialchars(trim(addslashes(utf8_decode($campo))), ENT_QUOTES, 'UTF-8');
}

function protecaoCampoFormulario2($campo) {
    return htmlspecialchars(trim(addslashes($campo)), ENT_QUOTES, 'UTF-8');
}

function validaCaptcha($key) {
    $resp = recaptcha_check_answer($key, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
    if (!$resp->is_valid) {
        return false;
    } else {
        return true;
    }
}

function isValidDateTime($dateTime) {
    if (preg_match("/^(\d{4})-(\d{2})-(\d{2}) ([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/", $dateTime, $matches)) {
        if (checkdate($matches[2], $matches[3], $matches[1])) {
            return true;
        }
    }
    return false;
}

// valida hora 23:59
function checktime($time) {
    list($hour, $minute) = explode(':', $time);

    if ($hour > -1 && $hour < 24 && $minute > -1 && $minute < 60) {
        return true;
    } else
        return false;
}

// valida data 
function checkData($date) {
    if (!isset($date) || $date == "") {
        return false;
    }

    list($dd, $mm, $yy) = explode("/", $date);
    if ($dd != "" && $mm != "" && $yy != "") {
        if (is_numeric($yy) && is_numeric($mm) && is_numeric($dd)) {
            return checkdate($mm, $dd, $yy);
        }
    }
    return false;
}

function gerarToken() {
    $Token = md5(uniqid(rand(), true));
    return $Token;
}

function gerarToken2() {
    $timestamp = time();
    $Token = md5(uniqid(rand() . $timestamp, true));
    return $Token;
}

function gerarTokenSha512() {
    $Token = hash('sha512', uniqid(rand()) . palavra_passe);
    return $Token;
}

function gerarTokenSessao($pass) {
    return hash('sha256', $pass . time());
}

//--------------------------------------------------------------------------------
// Função que valida o CPF

function validaCPF($cpf) {
    // Verifiva se o número digitado contém todos os digitos
    $cpf = str_pad(ereg_replace('[^0-9]', '', $cpf), 11, '0', STR_PAD_LEFT);

    // Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
    if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999') {
        return false;
    } else {
        // Calcula os números para verificar se o CPF é verdadeiro
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf{$c} != $d) {
                return false;
            }
        }
        return true;
    }
}

function validaCNPJ($cnpj) {
//    $cnpj = str_pad(ereg_replace('[^0-9]', '', $cnpj), 11, '0', STR_PAD_LEFT);
    if (strlen($cnpj) <> 18)
        return 0;
    $soma1 = ($cnpj[0] * 5) +
            ($cnpj[1] * 4) +
            ($cnpj[3] * 3) +
            ($cnpj[4] * 2) +
            ($cnpj[5] * 9) +
            ($cnpj[7] * 8) +
            ($cnpj[8] * 7) +
            ($cnpj[9] * 6) +
            ($cnpj[11] * 5) +
            ($cnpj[12] * 4) +
            ($cnpj[13] * 3) +
            ($cnpj[14] * 2);
    $resto = $soma1 % 11;
    $digito1 = $resto < 2 ? 0 : 11 - $resto;
    $soma2 = ($cnpj[0] * 6) +
            ($cnpj[1] * 5) +
            ($cnpj[3] * 4) +
            ($cnpj[4] * 3) +
            ($cnpj[5] * 2) +
            ($cnpj[7] * 9) +
            ($cnpj[8] * 8) +
            ($cnpj[9] * 7) +
            ($cnpj[11] * 6) +
            ($cnpj[12] * 5) +
            ($cnpj[13] * 4) +
            ($cnpj[14] * 3) +
            ($cnpj[16] * 2);
    $resto = $soma2 % 11;
    $digito2 = $resto < 2 ? 0 : 11 - $resto;
    return (($cnpj[16] == $digito1) && ($cnpj[17] == $digito2));
}

function text_to_array($str) {

    //Initialize arrays
    $keys = array();
    $values = array();
    $output = array();

    //Is it an array?
    if (substr($str, 0, 5) == 'Array') {

        //Let's parse it (hopefully it won't clash)
        $array_contents = substr($str, 7, -2);
        $array_contents = str_replace(array(' ', '[', ']', '=>'), array('', '#!#', '#?#', ''), $array_contents);
        $array_fields = explode("#!#", $array_contents);

        //For each array-field, we need to explode on the delimiters I've set and make it look funny.
        for ($i = 0; $i < count($array_fields); $i++) {

            //First run is glitched, so let's pass on that one.
            if ($i != 0) {

                $bits = explode('#?#', $array_fields[$i]);
                if ($bits[0] != '')
                    $output[$bits[0]] = $bits[1];
            }
        }

        //Return the output.
        return $output;
    } else {

        //Duh, not an array.
        echo 'The given parameter is not an array.';
        return null;
    }
}

function gerar_senha($tamanho, $maiuscula, $minuscula, $numeros, $codigos) {
    $maius = "ABCDEFGHIJKLMNOPQRSTUWXYZ";
    $minus = "abcdefghijklmnopqrstuwxyz";
    $numer = "0123456789";
    $codig = '!@#$%&*()-+.,;?{[}]^><:|';
    $base = '';
    $base .= ($maiuscula) ? $maius : '';
    $base .= ($minuscula) ? $minus : '';
    $base .= ($numeros) ? $numer : '';
    $base .= ($codigos) ? $codig : '';
    srand((float) microtime() * 10000000);
    $senha = '';
    for ($i = 0; $i < $tamanho; $i++) {
        $senha .= substr($base, rand(0, strlen($base) - 1), 1);
    }
    return $senha;
}

function verificaClienteLogado() {
    if (!isset($_SESSION)) {
        session_start();
    }
    if ($_SESSION["dados_cliente"]["dados_sessao"] != null) {
        return true;
    } else
        return false;
}

//------------------------------------------------------------------------------------
//funçao de validação de email
function validaEmail($email) {
    if (preg_match('/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/', $email))
        return true;
    else
        return false;
}

function check_email_mx($email2) {
    if (preg_match('/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/', $email2)) {
        $host = explode('@', $email2);
        if (checkdnsrr($host[1] . '.', 'MX'))
            return true;
        if (checkdnsrr($host[1] . '.', 'A'))
            return true;
        if (checkdnsrr($host[1] . '.', 'CNAME'))
            return true;
    }
    return false;
}

//------------------------------------------------------------------------------
//funcao de verificação de cpf Unico
function validaCpfUnico($cpf) {
    // Configurações do sistema
    require("../configuracao/configurator.php");
    //inclusão das classes
    include_once($config["classes"] . "/usuario.classes.php");
    include_once($config["dao"] . "/usuarioDao.php");

    //instanciação dos objetos
    $_usuario = new UsuarioDao();

    if ($_usuario->verificaCpf($cpf))
        return true;
    else
        return false;
}

function validaEmailUnico($email) {

    include_once (dao . '/utilDao.php');
    $_utilDao = new UtilDao();

    if ($_utilDao->verificarDisponibilidadeEmail($email)) {

        return true;
    } else
        return false;
}

function validaEmailUnico2($email) {
    $_newsletterDao = new NewsletterDao();

    if ($_newsletterDao->verificarDisponibilidadeEmail($email))
        return true;
    else
        return false;
}

function get_ip() {
    $variables = array('REMOTE_ADDR',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'HTTP_X_COMING_FROM',
        'HTTP_COMING_FROM',
        'HTTP_CLIENT_IP');

    $return = '';

    foreach ($variables as $variable) {
        if (isset($_SERVER[$variable])) {
            $return.= $_SERVER[$variable] . ";";
        }
    }

    return $return;
}

//-------------------------------------------------------------------------------
//função que monta um array para paginação dos registros
function montaPaginacao($totRegistros, $porPagina, $pagina) {
    $paginas = array();

    $totPaginas = ceil($totRegistros / $porPagina);

    if ($pagina > 1) {
        $paginas[] = array("url" => ($pagina - 1), "anterior" => 1, "ativo" => 0);
    } else {
        $paginas[] = array("url" => "", "anterior" => 1, "ativo" => 1);
    }
    if (($totPaginas - $pagina) > 2)
        $value = 2 + $pagina;
    else
        $value = $totPaginas;
    if (($pagina) > 1)
        $val = $pagina - 1;
    else
        $val = 1;
    if ($totPaginas > 0) {
        for ($i = $val; $i <= $value; $i++) {
            if ($pagina == $i)
                $paginas[] = array("url" => $i, "ativo" => 1, "item" => 1);
            else
                $paginas[] = array("url" => "$i", "ativo" => 0, "item" => 1);
        }
    }else {
        $paginas[] = array("url" => "1", "ativo" => 1);
    }

    if ($pagina < $totPaginas) {
        $paginas[] = array("url" => ($pagina + 1), "ativo" => 0, "proximo" => 1);
    } else {
        $paginas[] = array("url" => "", "ativo" => 1, "proximo" => 1);
    }

    return $paginas;
}

function montaPaginacao2($totRegistros, $porPagina, $pagina, $url, $url2 = "") {
    $paginas = array();

    $totPaginas = ceil($totRegistros / $porPagina);

    if ($pagina > 1) {
        $paginas[] = array("url" => $url . ($pagina - 1), "anterior" => 1, "ativo" => 0);
    } else {
        $paginas[] = array("url" => "", "anterior" => 1, "ativo" => 1);
    }
    if (($totPaginas - $pagina) > 2)
        $value = 2 + $pagina;
    else
        $value = $totPaginas;
    if (($pagina) > 1)
        $val = $pagina - 1;
    else
        $val = 1;
    if ($totPaginas > 0) {
        for ($i = $val; $i <= $value; $i++) {
            if ($pagina == $i)
                $paginas[] = array("url" => $url . $i . $url2, "ativo" => 1, "item" => 1, "index" => $i);
            else
                $paginas[] = array("url" => $url . $i . $url2, "ativo" => 0, "item" => 1, "index" => $i);
        }
    }else {
        $paginas[] = array("url" => $url . "1", "ativo" => 1);
    }

    if ($pagina < $totPaginas) {
        $paginas[] = array("url" => $url . ($pagina + 1) . $url2, "ativo" => 0, "proximo" => 1, "index" => ($pagina + 1));
    } else {
        $paginas[] = array("url" => "", "ativo" => 1, "proximo" => 1);
    }

    return $paginas;
}

//------------------------------------------------------------------------------------
//função que monta um array para paginação dos registros
function montaPaginacaoAjax($totRegistros, $porPagina, $pagina, $url) {
    // paginação
    $paginas = array();
    $totPaginas = ceil($totRegistros / $porPagina);

    if ($pagina > 1) {
        $paginas[] = array("url" => "$url", "anterior" => 1, "ativo" => 0);
    } else {
        $paginas[] = array("url" => "", "anterior" => 1, "ativo" => 1);
    }
    if (($totPaginas - $pagina) > 6)
        $value = 6 + $pagina;
    else
        $value = $totPaginas;
    if (($pagina) > 5)
        $val = $pagina - 5;
    else
        $val = 1;
    if ($totPaginas > 0) {
        for ($i = $val; $i <= $value; $i++) {
            if ($pagina == $i)
                $paginas[] = array("url" => "$url" . $i, "ativo" => 1, "item" => 1, "index" => $i);
            else
                $paginas[] = array("url" => "$url" . $i, "ativo" => 0, "item" => 1, "index" => $i);
//                 $paginas[] = array("url" => "", "ativo" => 0, "item" => 1);
        }
    }else {
        $paginas[] = array("url" => "#", "ativo" => 1, "indice" => "1");
    }

    if ($pagina < $totPaginas) {
        $paginas[] = array("url" => "$url" . $i, "ativo" => 0, "proximo" => 1, "index" => $i);
    } else {
        $paginas[] = array("url" => "", "ativo" => 1, "proximo" => 1);
    }

    return $paginas;
}

function montaPaginacaoAjax2($totRegistros, $porPagina, $pagina, $url, $url2, $url3) {
    // paginação
    $paginas = array();
    $totPaginas = ceil($totRegistros / $porPagina);

    if ($pagina > 1) {
        $paginas[] = array("url" => $url, "anterior" => 1, "ativo" => 0);
    } else {
        $paginas[] = array("url" => "", "anterior" => 1, "ativo" => 1);
    }
    if (($totPaginas - $pagina) > 6)
        $value = 6 + $pagina;
    else
        $value = $totPaginas;
    if (($pagina) > 5)
        $val = $pagina - 5;
    else
        $val = 1;
    if ($totPaginas > 0) {
        for ($i = $val; $i <= $value; $i++) {
            if ($pagina == $i)
                $paginas[] = array("url" => $i, "ativo" => 1, "item" => 1);
            else
                $paginas[] = array("url" => "$i", "ativo" => 0, "item" => 1);
//                 $paginas[] = array("url" => "", "ativo" => 0, "item" => 1);
        }
    }else {
        $paginas[] = array("url" => "1", "ativo" => 1);
    }

    if ($pagina < $totPaginas) {
        $paginas[] = array("url" => $url3, "ativo" => 0, "proximo" => 1);
    } else {
        $paginas[] = array("url" => "", "ativo" => 1, "proximo" => 1);
    }

    return $paginas;
}

function montaPaginacaoAjax3($totRegistros, $porPagina, $pagina, $url, $url2, $url3) {

// paginação
    $paginas = array();
    $totPaginas = ceil($totRegistros / $porPagina);

    if ($pagina > 1) {
        $paginas[] = array("url" => $url, "anterior" => 1, "ativo" => 0);
    } else {
        $paginas[] = array("url" => "", "anterior" => 1, "ativo" => 1);
    }
    if (($totPaginas - $pagina) > 6)
        $value = 6 + $pagina;
    else
        $value = $totPaginas;
    if (($pagina) > 5)
        $val = $pagina - 5;
    else
        $val = 1;
    if ($totPaginas > 0) {
        for ($i = $val; $i <= $value; $i++) {
            if ($pagina == $i)
                $paginas[] = array("url" => $url2, "ativo" => 1, "item" => 1, $indice => $i);
            else
//                $paginas[] = array("url" => "<a href='$url2&pag=$i'>$i</a>", "ativo" => 0, "item" => 1);
                $paginas[] = array("url" => "", "ativo" => 0, "item" => 1, $indice => "");
        }
    }else {
        $paginas[] = array("url" => "1", "ativo" => 1);
    }

    if ($pagina < $totPaginas) {
        $paginas[] = array("url" => $url3, "ativo" => 0, "proximo" => 1);
    } else {
        $paginas[] = array("url" => "", "ativo" => 1, "proximo" => 1);
    }

    return $paginas;
}

function embedVideo($url, $width, $height) {
    /*
     * RETORNA VIDEOS DO YOUTUBE E METACAFE
     *
     * É POSSÍVEL IMPLEMENTAR MAIS EXPRESSÕES REGULARES
     *
     * é possível adaptar um retorno em string também,
     * aí fica a critério de quem usar a função
     *
     */

    if (preg_match("#http://(.*)\.youtube\.com/watch\?v=(.*)(&(.*))?#", $url, $matches)) {
        return '
            <object width="' . $width . '" height="' . $height . '">
               <param name="movie" value="http://www.youtube.com/v/' . $matches[2] . '&hl=pt-br&fs=1"></param>
               <param name="allowFullScreen" value="true"></param>
               <param name="allowscriptaccess" value="always"></param>
               <embed src="http://www.youtube.com/v/' . $matches[2] . '&hl=pt-br&fs=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="' . $width . '" height="' . $height . '"></embed>
            </object>
            ';
    } elseif (preg_match("#http://www\.metacafe\.com/watch/(([^/].*)/([^/].*))/?#", $url, $matches)) {
        return '<embed flashVars="playerVars=showStats=no|autoPlay=no|videoTitle="  src="http://www.metacafe.com/fplayer/' . $matches[1] . '.swf" width="' . $width . '" height="' . $height . '" wmode="transparent" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"></embed>';
    }
}

// trata imagens
function redimensiona_imagem($filename, $width, $height) {
    list($width, $height) = getimagesize($filename);
    if ($width > $height) {
        //setando a largura da miniatura
        $new_width = 80;
        //setando a altura da miniatura
        $new_height = 60;
        //gerando a a miniatura da imagem
        $image_p = imagecreatetruecolor($new_width, $new_height);
        $image = imagecreatefromjpeg($filename);
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    } else {
        //setando a largura da miniatura
        $new_width = 60;
        //setando a altura da miniatura
        $new_height = 80;
        //gerando a a miniatura da imagem
        $image_p = imagecreatetruecolor($new_width, $new_height);
        $image = imagecreatefromjpeg($filename);
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    }
//o 3º argumento é a qualidade da imagem de 0 a 100
    imagejpeg($image_p, null, 80);
    imagedestroy($image_p);

    return true;
}

function redimensiona_fixo($origem, $destino, $maxlargura, $maxaltura, $qualidade = 80) {
    if (!strstr($origem, "http") && !file_exists($origem)) {
        echo("Arquivo de origem da imagem inexistente");
        return false;
    }
    $ext = strtolower(end(explode('.', $origem)));
    if ($ext == "jpg" || $ext == "jpeg") {
        $img_origem = @imagecreatefromjpeg($origem);
    } elseif ($ext == "gif") {
        $img_origem = @imagecreatefromgif($origem);
    } elseif ($ext == "png") {
        $img_origem = @imagecreatefrompng($origem);
    }
    if (!$img_origem) {
        echo("Erro ao carregar a imagem, talvez formato nao suportado");
        return false;
    }$maxAltura = 20;
    do {
        $alt_origem = imagesy($img_origem);
        $lar_origem = imagesx($img_origem);
        $escala = min($maxAltura / $alt_origem, $maxAltura / $lar_origem);
        $alt_destino = floor($escala * $alt_origem);
        $lar_destino = floor($escala * $lar_origem);
        $maxAltura = $maxAltura + 2;
    } while ($alt_destino <= $maxaltura or $lar_destino <= $maxlargura);
    $alt = ceil((((50 * $alt_destino) / 100)) - ceil($maxaltura / 2));
    $lar = ceil((((50 * $lar_destino) / 100)) - ceil($maxlargura / 2));
// Cria imagem de destino
    $img_destino = imagecreatetruecolor($maxlargura, $maxaltura);
// Redimensiona
    imagecopyresampled($img_destino, $img_origem, -$lar, -$alt, 0, 0, $lar_destino, $alt_destino, $lar_origem, $alt_origem);
    imagedestroy($img_origem);
    $ext = strtolower(end(explode('.', $destino)));
    if ($ext == "jpg" || $ext == "jpeg") {
        imagejpeg($img_destino, $destino, $qualidade);
        return true;
    } elseif ($ext == "gif") {
        imagepng($img_destino, $destino);
        return true;
    } elseif ($ext == "png") {
        imagepng($img_destino, $destino);
        return true;
    } else {
        echo("Formato de destino nao suportado");
        return false;
    }
}

function dimensao_proporcional($origem) {
    $ext = strtolower(end(explode('.', $origem)));
    if ($ext == "jpg" || $ext == "jpeg") {
        $img_origem = @imagecreatefromjpeg($origem);
    } elseif ($ext == "gif") {
        $img_origem = @imagecreatefromgif($origem);
    } elseif ($ext == "png") {
        $img_origem = @imagecreatefrompng($origem);
    }

    $old_x = imageSX($img_origem);
    $old_y = imageSY($img_origem);

    $new_y = ($old_x < 1000 ? $old_y : ($old_x <= 1400 ? $old_y / 2 : $old_y / 4));

    $new_x = ($old_x * $new_y) / $old_y;
    return array("new_x" => $new_x, "new_y" => $new_y);
}

function reduz_imagem($img_name, $filename, $new_w, $new_h) {
    $ext = getExtension($img_name);
    if (!strcmp("jpg", $ext) || !strcmp("jpeg", $ext)) {
        $src_img = imagecreatefromjpeg($img_name);
        if (!$src_img) {
            return false;
        }
    } else {
        return false;
    }
    $old_x = imageSX($src_img);
    $old_y = imageSY($src_img);
    $ratio1 = $old_x / $new_w;
    $ratio2 = $old_y / $new_h;
    if ($ratio1 > $ratio2) {
        $thumb_w = $new_w;
        $thumb_h = $old_y / $ratio1;
    } else {
        $thumb_h = $new_h;
        $thumb_w = $old_x / $ratio2;
    }
    $dst_img = ImageCreateTrueColor($thumb_w, $thumb_h);
    if ($dst_img) {
        if (!imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y)) {
            return false;
        }
    } else {
        return false;
    }
    if (!imagejpeg($dst_img, $filename)) {
        return false;
    }
    if (!imagedestroy($dst_img)) {
        return false;
    }
    if (!imagedestroy($src_img)) {
        return false;
    }
    return true;
}

function make_thumb($img_name, $filename, $new_w, $new_h) {
    $ext = getExtension($img_name);
    if (!strcmp("jpg", $ext) || !strcmp("jpeg", $ext))
        $src_img = imagecreatefromjpeg($img_name);
//        echo "IMAGEM_NOM:$img_name E FILENAME: $filename";
//    if (!strcmp("png", $ext))
//        $src_img = imagecreatefrompng($img_name);
    $old_x = imageSX($src_img);
    $old_y = imageSY($src_img);
    $ratio1 = $old_x / $new_w;
    $ratio2 = $old_y / $new_h;
    if ($ratio1 > $ratio2) {
        $thumb_w = $new_w;
        $thumb_h = $old_y / $ratio1;
    } else {
        $thumb_h = $new_h;
        $thumb_w = $old_x / $ratio2;
    }
    $dst_img = ImageCreateTrueColor($thumb_w, $thumb_h);
    imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y);
//    if (!strcmp("png", $ext))
//        imagepng($dst_img, $filename);
//    else

    imagejpeg($dst_img, $filename);
    imagedestroy($dst_img);
    imagedestroy($src_img);
}

function getExtension($str) {
    $i = strrpos($str, ".");
    if (!$i) {
        return "";
    }
    $l = strlen($str) - $i;
    $ext = substr($str, $i + 1, $l);
    return $ext;
}

function verificacaoDePastas($tipo) {
    if ($tipo == "projeto") {
        
    }
}

function convertlink($name) {
    $name = strtolower($name);
    $name = ereg_replace("-", " ", $name);
    $name = ereg_replace("  ", "", $name);

    $array1 = array("á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç", "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç", " ", "'", "´", "`", "/", "\\", "~", "^", "¨", "?", "!", "<", ">", "(", ")", ",", ".", "_", "&lt;", "&gt;", ":", "+", "[", "]", "*", "$", "%");

    $array2 = array("a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c", "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C", "-", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "");
    return str_replace($array1, $array2, $name);
}

function getUrlFriendlyString($str) {
    return strtolower(strip_tags(preg_replace(array('/[`^~\'"]/', '/([\s]{1,})/', '/[-]{2,}/'), array(null, '-', '-'), iconv('UTF-8', 'ASCII//TRANSLIT', $str))));
}

function url_amigavel($string) {
    $table = array(
        'Š' => 'S', 'š' => 's', 'Đ' => 'Dj', 'đ' => 'dj', 'Ž' => 'Z',
        'ž' => 'z', 'Č' => 'C', 'č' => 'c', 'Ć' => 'C', 'ć' => 'c',
        'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A',
        'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
        'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I',
        'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O',
        'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U',
        'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss',
        'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a',
        'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e',
        'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i',
        'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o',
        'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u',
        'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b',
        'ÿ' => 'y', 'Ŕ' => 'R', 'ŕ' => 'r',
    );
    // Traduz os caracteres em $string, baseado no vetor $table
    $string = strtr($string, $table);
    // converte para minúsculo
    $string = strtolower($string);
    // remove caracteres indesejáveis (que não estão no padrão)
    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
    // Remove múltiplas ocorrências de hífens ou espaços
    $string = preg_replace("/[\s-]+/", " ", $string);
    // Transforma espaços e underscores em hífens
    $string = preg_replace("/[\s_]/", "-", $string);
    // retorna a string
    return $string;
}

//var_dump(url_amigavel('Isso é um teste de ação'));
// string(23) "isso-e-um-teste-de-acao"


function converterNomeArquivo($name) {
    header("Content-Type: text/html; charset=ISO-8859-1", true);
    $name = strtolower($name);
    $name = ereg_replace("-", " ", $name);
    $name = ereg_replace("  ", "", $name);
    $array1 = array("á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç", "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç", " ", "'", "´", "`", "/", "\\", "~", "^", "¨", "?", "!", "<", ">", "(", ")", ",", "_", "&lt;", "&gt;", ":", "+", "[", "]", "*", "$", "%");
    $array2 = array("a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c", "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C", "-", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "");
    return str_replace($array1, $array2, $name);
}

function httpsRedirect() {
    if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "") {
        $redirect = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header("Location: $redirect");
    }
}

function validaUrl($url) {

    if (substr($url, 0, 7) == "https://" || substr($url, 0, 5) == "ftp://") {
        return false;
    }
    if (substr($url, 0, 6) != "http://") {
        $url_temp = "http://" . $url;
    } else {
        $url_temp = $url;
    }

    if (!filter_var($url_temp, FILTER_VALIDATE_URL)) {
        return false;
    } else {
        return true;
    }
}

function urlExists($url = NULL) {
    if ($url == NULL)
        return false;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($httpcode >= 200 && $httpcode < 300) {
        return true;
    } else {
        return false;
    }
}

function downloadFile($file) {
    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file));
        ob_get_clean();
        @readfile($file);
        ob_end_flush();
        exit;
    }
}

function onlyNumbers($value) {
    $name_final = $value;
    $array1 = array("(", ")", "-", ".");
    $array2 = array("", "", "", "");
    return str_replace($array1, $array2, $name_final);
}

function stringToDateTime($dateString, $timeString) {
    $array_data = split("/", $dateString);
    return $array_data[2] . "-" . $array_data[1] . "-" . $array_data[0] . " " . $timeString . ":00";
}

function returnInsertableDate($date) {
    $campos = split("/", $date);
    return $campos[2] . "-" . $campos[1] . "-" . $campos[0];
}

function dateTimeReturnData($datetime) {
    $array_data = split(" ", $datetime);
    $data = $array_data[0];
    $data_simples = split("-", $data);
    return $data_simples[2] . "/" . $data_simples[1] . "/" . $data_simples[0];
}

function dateTimeReturnTime($datetime) {
    $array_data = split(" ", $datetime);
    $hora = $array_data[1];
    $hora_simples = split(":", $hora);
    return $hora_simples[0] . ":" . $hora_simples[1];
}

function backUrl() {
    $cur_page = fGet('pg');
    $back_url = site;
    foreach ($_GET as $key => $value) {
        if ($key == 'senha' || $key == 'password' || $key == 'senha2') {
            continue;
        } elseif ($key == 'pg') {
            $back_url += '!' . $key . '!' . $value;
        } else {
            $back_url += '&' . $key . '=' . $value;
        }
    }
    return urlencode($back_url);
}
?>

