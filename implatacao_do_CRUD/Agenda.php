<?php
class Agenda {
    private $codigo, $cpf, $data, $descricao;

    // Adicionado getter/setter para codigo
    public function getCodigo() { return $this->codigo; }
    public function setCodigo($codigo) { $this->codigo = $codigo; }

    public function getCpf() { return $this->cpf; }
    public function setCpf($cpf) { $this->cpf = $cpf; }

    public function getData() { return $this->data; }
    public function setData($data) { $this->data = $data; }

    public function getDescricao() { return $this->descricao; }
    public function setDescricao($descricao) { $this->descricao = $descricao; }
}
?>