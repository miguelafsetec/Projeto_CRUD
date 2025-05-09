<?php
    include "conexao.php";    
    //DAO - CRUD - create, read, update, delete
    class ModelPessoa{
        public function inserir(Pessoa $pessoa){
            $sql = "insert into pessoa(cpf, nome, contato) 
            values(?, ?, ?)";
            $con = new Conexao();
            $bd = $con->pegarConexao();

            $stm = $bd->prepare($sql);
            $stm->bindValue(1, $pessoa->getCpf());
            $stm->bindValue(2, $pessoa->getNome());
            $stm->bindValue(3, $pessoa->getContato());
            $result = $stm->execute();
            if($result){
                echo "cadastrado com sucesso";
            }else{
                echo "erro ao cadastrar";
            }
        }
    }
?>