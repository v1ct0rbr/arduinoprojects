<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UsuarioDao
 *
 * @author Victor
 */
class UsuarioDao extends Usuario {

    public function login() {
//        require_once classes . "/operacao.classes.php";
        parent::conectarBD();

        $queri = parent::query(sprintf("select usu_id as codigo, usu_password as senha, "
                                . "usu_token_sessao as token_sessao, usu_login as login from "
                                . table_prefix . "usuario where usu_login = '%s' and "
                                . "usu_password = '%s'", $this->usu_login, $this->usu_password));

        if ($queri) {
            $dados = $queri->fetch_assoc();
            if ($dados) {
                $new_session_id = hash('sha256', $dados['senha'] . time());
                $queri2 = parent::query("update " . table_prefix . "usuario set usu_token_sessao = '$new_session_id' where usu_id = " . $dados['codigo']);

                if ($queri2) {
                    $dados['token_sessao'] = $new_session_id;
                    parent::commit();
                    parent::desconectarBD();
                    return $dados;
                } else {
                    parent::rollback();
                    parent::desconectarBD();
                    return false;
                }
            } else {
                parent::desconectarBD();
                return false;
            }
        } else {
            parent::desconectarBD();
            return false;
        }
    }

    public function verificarSessionId($codigo) {
        parent::conectarBD();
        $queri = parent::query("select usu_token_sessao as session_id from " . table_prefix . "usuario where usu_id = '$codigo'");
        if ($queri) {
            $dados = $queri->fetch_assoc();
            if ($dados) {
                parent::desconectarBD();
                return $dados['session_id'];
            } else {
                return false;
            }
        } else {
            parent::desconectarBD();
            return false;
        }
    }

    public function adicionarUsuario() {
        global $messages;
        $queri1 = parent::query(sprintf("select usu_id from " . table_prefix . "usuario where usu_login = '%s'", $this->usu_login));

        if ($queri1) {
            $dados = parent::fetch_rows($queri1);
            if (!$dados) {
                $queri2 = parent::query("insert into " . table_prefix . "usuario (usu_login, 
                                usu_password, usu_token_sessao)
                                values ('$this->usu_login', '$this->usu_password', "
                                . "'$this->usu_token_sessao')");
                if ($queri2) {
                    $id = parent::get_insert_id();
                    return $id;
                } else {
                    return false;
                }
            } else {
                $messages['error'][] = 'Já existe outro usuário com login ou e-mail iguais ao fornecido.';
                return false;
            }
        } else {
            return false;
        }
    }

    public function autoUpdate() {
        global $json;
        parent::conectarBD();
        $result = false;
        $queri1 = parent::query(sprintf("select usu_id from " . table_prefix . "usuario where "
                                . "usu_id <> '%d' usu_login <> '%s'", $this->usu_id, $this->usu_login));
        if ($queri1) {
            $dados = parent::fetch_rows($queri1);
            if (!$dados) {
                $queri2 = parent::query(sprintf("update " . table_prefix . "usuario set "
                                        . "usu_password = '%s', usu_token_sessao = '%s' "
                                        . "where usu_id = '%d'", $this->usu_password, $this->usu_token_sessao, $this->usu_id));
                if ($queri2) {
                    parent::commit();
                    $result = true;
                } else {
                    parent::rollback();
                    $json['messages']['error'] = 'Erro no banco de dados';
                    $result = false;
                }
            } else {
                $json['messages']['error'] = 'Existe outro usuário com o mesmo e-mail';
                $result = false;
            }
        } else {
            $json['messages']['error'] = 'Erro no banco de dados';
            $result = false;
        }
        parent::desconectarBD();
        return $result;
    }

    public function atualizarUsuarioSenha() {
        if (!$this->isMasterAdmin($this->usu_id)) {
            $queri1 = parent::query(sprintf("update " . table_prefix . "usuario set usu_password = '%s', "
                                    . "usu_token_sessao = '%s' where usu_id = '%d'", $this->usu_password, $this->usu_token_sessao, $this->usu_id));
            if ($queri1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function delecaoTotalUsuario() {
        global $messages;


        $queri2 = parent::query(sprintf("delete from " . table_prefix . "usuario "
                                . " where usu_id = '%d'", $this->usu_id));
        if ($queri2) {
            return true;
        } else {
            $messages['error'][] = 'Erro na exclusão.';
            return false;
        }
    }

    public function listUserById($codigo) {
        parent::conectarBD();

        $queri = parent::query(sprintf("select usu_id as codigo, usu_login as login from " . table_prefix
                                . "usuario where usu_id = '%d'", $codigo));
        if ($queri) {
            $dados = $queri->fetch_assoc();
            if ($dados['codigo']) {
                parent::desconectarBD();
                return $dados;
            } else {
                parent::desconectarBD();
                return false;
            }
        }
    }

    public function listarTokenSessaoUsuario($codigo) {



        parent::conectarBD();

        $queri = parent::query("select usu_token_sessao as token from " . table_prefix . "usuario where usu_id = '$codigo'");

        if ($queri) {
            $dados = $queri->fetch_assoc();
            parent::desconectarBD();
            if ($dados)
                return $dados[token];
            else
                return false;
        } else {
            parent::desconectarBD();
            return false;
        }
    }

}

?>
