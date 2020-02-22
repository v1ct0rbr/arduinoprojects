
<?php

/* * *********************************************************** */
/* * ********************** Classe usuario ********************* */
/* * ************ Desenvolvido por Victor Queiroga ************** */
/* * *********************************************************** */

class Usuario extends BD {

    protected $usu_id;
    protected $usu_login;
    protected $usu_password;
    protected $usu_token_sessao;

    function getUsu_id() {
        return $this->usu_id;
    }

    function getUsu_login() {
        return $this->usu_login;
    }

    function getUsu_password() {
        return $this->usu_password;
    }

    function getUsu_token_sessao() {
        return $this->usu_token_sessao;
    }

    function setUsu_id($usu_id) {
        $this->usu_id = $usu_id;
    }

    function setUsu_login($usu_login) {
        $this->usu_login = $usu_login;
    }

    function setUsu_password($usu_password) {
        $this->usu_password = $usu_password;
    }

    function setUsu_token_sessao($usu_token_sessao) {
        $this->usu_token_sessao = $usu_token_sessao;
    }

}

//fim da classe
?>