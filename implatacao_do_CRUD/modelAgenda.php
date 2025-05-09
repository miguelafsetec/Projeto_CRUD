<?php
require_once("conexao.php");
require_once("agenda.php");

class ModelAgenda {
    private $conn;

    public function __construct() {
        $this->conn = Conexao::pegarConexao();
    }

    public function inserir(Agenda $agenda) {
        $stmt = $this->conn->prepare("INSERT INTO agenda (cpf, data, descricao) VALUES (?, ?, ?)");
        $stmt->execute([
            $agenda->getCpf(),
            $agenda->getData(),
            $agenda->getDescricao()
        ]);
    }

    public function atualizar(Agenda $agenda) {
        $stmt = $this->conn->prepare("UPDATE agenda SET cpf=?, data=?, descricao=? WHERE codigo=?");
        $stmt->execute([
            $agenda->getCpf(),
            $agenda->getData(),
            $agenda->getDescricao(),
            $agenda->getCodigo()
        ]);
    }

    public function apagar($codigo) {
        $stmt = $this->conn->prepare("DELETE FROM agenda WHERE codigo=?");
        $stmt->execute([$codigo]);
    }

    public function consultar() {
        $stmt = $this->conn->query("SELECT a.codigo, a.cpf, p.nome, a.data, a.descricao 
                                    FROM agenda a 
                                    JOIN pessoa p ON a.cpf = p.cpf");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
