<?php
    //Objeto Entidade Pessoa
    class Pessoa{   
        private $cpf, $nome, $contato;

        public function getCpf(){
            return $this->cpf;
        }
        public function setCpf($cpf){
            $this->cpf = $cpf;
        }

        public function getNome(){
            return $this->nome;
        }
        public function setNome($nome){
            $this->nome = $nome;
        }

        public function getContato(){
            return $this->contato;
        }
        public function setContato($contato){
            $this->contato = $contato;
        }
    }
?>