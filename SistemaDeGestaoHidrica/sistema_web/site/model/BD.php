<?php

class BD {

    private $usuario;
    private $senha;
    private $conexao;
    private $banco;
    private $servidor;

    public function __construct() {
//        global $config;

        $this->usuario = bd_login;
        $this->senha = bd_senha;
        $this->servidor = bd_servidor;
        $this->banco = bd_base;
    }

    public function conectarBD() {
        $this->conexao = new MySQLi($this->servidor, $this->usuario, $this->senha, $this->banco);
        $this->conexao->set_charset(bd_charset);
        if (!$this->conexao) {

            throw new Exception("Não foi possível se conectar ao banco de dados!");
            exit;
        }

        $this->conexao->autocommit(false);
    }

    public function setConection($conn) {
        $this->conexao = $conn;
    }

    public function desconectarBD() {
        mysqli_close($this->conexao);
    }

    public function get_insert_id() {
        return $this->conexao->insert_id;
    }

    public function commit() {
        if ($this->conexao)
            $this->conexao->commit();
    }

    public function rollback() {
        if ($this->conexao)
            $this->conexao->rollback();
    }

    public function query($select, $multi = false, $teste ="") {
        global $messages;
        global $json;
        try {
            if (!$this->conexao) {
                print_r($this->conexao);

                throw new Exception("Não foi possível se conectar ao banco de dados!");
                return false;
            } else {
                if ($multi) {
                    $q = $this->conexao->multi_query($select);
                } else {
                    $q = $this->conexao->query($select);
                }

                if (!$q) {
                    throw new Exception($this->getError());
                    return false;
                } else
                    return $q;
            }
        } catch (Exception $e) {
                      
            $messages['error'][] = "Exceção: " . $e->getMessage(). $teste;
//            $messages['error'][] = "Exceção pega: " . print_r($e->getTrace());
            $json['messages']['error'][] = $e->getMessage();
//            echo "Exceção pega: ", $e->getMessage(), "\n";
        }
    }

    public function fetch_rows($query) {


        $dados = array();

        while ($dadosItem = $query->fetch_assoc()) {
            $dados[] = $dadosItem;
        }

        return $dados;
    }

    public function numeroDeLinhas($query) {
        return $this->conexao->mysql_num_rows($query);
    }

    public function getError() {
        return $this->conexao->error;
    }

    public function teste($valor) {
        $this->conectarBD();
        $queri = $this->query('insert into ' . table_prefix . 'teste (tes_texto, tes_data) values("' . $valor . '", now())');

        if ($queri) {
            $id = $this->get_insert_id();
            $this->commit();
            $this->desconectarBD();
            return $id;
        } else {
            $this->rollback();
            $this->desconectarBD();
            return false;
        }
    }

    public function registrarOperacao($operacao, $ip, $codigo, $detalhes = "") {
        $this->conectarBD();
        $queri = $this->query(sprintf("insert into " . table_prefix
                        . "operacao_usuario (ope_operacao_id, ope_ip, ope_usuario_id, ope_details, ope_data) "
                        . "values('%d', '%s', '%d', '%s', now())", $operacao, $ip, $codigo, $detalhes));

        if ($queri) {
            $id = $this->get_insert_id();
            $this->commit();
            $this->desconectarBD();
            return $id;
        } else {
            $this->rollback();
            $this->desconectarBD();
            return false;
        }
    }

}

?>				