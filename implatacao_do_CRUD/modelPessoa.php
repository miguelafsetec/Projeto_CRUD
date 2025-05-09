<?php
    include "conexao.php";
    class ModelPessoa{
        public function inserir(Pessoa $pessoa){
            $sql = "insert into pessoa(cpf, nome, contato) values(?, ?, ?)";
            $con = new Conexao();
            $bd = $con->pegarConexao();

            $stm = $bd->prepare($sql);
            $stm->bindValue(1, $pessoa->getCpf());
            $stm->bindValue(2, $pessoa->getNome());
            $stm->bindValue(3, $pessoa->getContato());
            $resultado = $stm->execute();
            if($resultado){
                echo "cadastrado com sucesso";
            }else{
                echo "erro ao cadastrar";
            }
        }

        public function apagar(Pessoa $pessoa){
            $sql = "delete from pessoa where cpf=?";
            $con = new Conexao();
            $bd = $con->pegarConexao();

            $stm = $bd->prepare($sql);
            $stm->bindValue(1, $pessoa->getCpf());
            $resultado = $stm->execute();
            if($resultado){
                echo "apagado com sucesso";
            }else{
                echo "erro ao apagar";
            }
        }

        public function atualizar(Pessoa $pessoa){
            $sql = "update pessoa set nome=?, contato=? where cpf=?";
            $con = new Conexao();
            $bd = $con->pegarConexao();

            $stm = $bd->prepare($sql);
            $stm->bindValue(1, $pessoa->getNome());
            $stm->bindValue(2, $pessoa->getContato());
            $stm->bindValue(3, $pessoa->getCpf());
            $resultado = $stm->execute();
            if($resultado){
                echo "atualizado com sucesso";
            }else{
                echo "erro ao atualizar";
            }
        }

        public function consultar(){
            $sql = "select * from pessoa";
            $con = new Conexao();
            $bd = $con->pegarConexao();

            $stm = $bd->prepare($sql);
            $stm->execute();
            
            if($stm->rowCount()>0){
                $resultado = $stm->fetchAll(\PDO::FETCH_ASSOC);
                return json_encode($resultado);
            }

        }
    }
?>