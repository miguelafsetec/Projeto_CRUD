<?php
include_once("conexao.php");
include_once("Agenda.php");

class ModelAgenda {

    public function inserir(Agenda $agenda) {
        $con = null;
        try {
            $con = Conexao::pegarConexao();

            // REMOVIDO: Bloco que verificava se o CPF existia na tabela pessoa
            /*
            $stmtCheck = $con->prepare("SELECT cpf FROM pessoa WHERE cpf = :cpf");
            $stmtCheck->bindValue(':cpf', $agenda->getCpf());
            $stmtCheck->execute();

            if ($stmtCheck->rowCount() == 0) {
                return json_encode(['sucesso' => false, 'mensagem' => 'Erro: CPF não encontrado na tabela de pessoas. Cadastre a pessoa primeiro.']);
            }
            */

            // Insere na agenda diretamente
            $sql = "INSERT INTO agenda (cpf, data, descricao) VALUES (:cpf, :data, :descricao)";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':cpf', $agenda->getCpf());
            $stmt->bindValue(':data', $agenda->getData());
            $stmt->bindValue(':descricao', $agenda->getDescricao());

            if ($stmt->execute()) {
                return json_encode(['sucesso' => true, 'mensagem' => 'Compromisso cadastrado com sucesso!']);
            } else {
                // error_log("Erro SQL: " . implode(":", $stmt->errorInfo()));
                return json_encode(['sucesso' => false, 'mensagem' => 'Erro ao cadastrar compromisso.']);
            }
        } catch (PDOException $e) {
            // error_log("Erro de Conexão/PDO: " . $e->getMessage());
            return json_encode(['sucesso' => false, 'mensagem' => 'Erro de banco de dados: ' . $e->getMessage()]);
        } finally {
             if ($con) {
               $con = null;
            }
        }
    }

    public function consultar($codigo = null) {
         $con = null;
        try {
            $con = Conexao::pegarConexao();
            // Mantém o LEFT JOIN para tentar buscar o nome se o CPF existir em pessoa
            $sql = "SELECT a.codigo, a.cpf, a.data, a.descricao, p.nome
                    FROM agenda a
                    LEFT JOIN pessoa p ON a.cpf = p.cpf"; // LEFT JOIN ainda funciona, retornará NULL para p.nome se o CPF não existir em pessoa

            if ($codigo) {
                $sql .= " WHERE a.codigo = :codigo";
                $stmt = $con->prepare($sql);
                $stmt->bindValue(':codigo', $codigo);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                 $stmt = $con->prepare($sql);
                 $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            // error_log("Erro de Conexão/PDO: " . $e->getMessage());
            return ['erro' => 'Erro ao consultar dados: ' . $e->getMessage()];
        } finally {
             if ($con) {
               $con = null;
            }
        }
    }

    public function atualizar(Agenda $agenda) {
        $con = null;
        try {
            $con = Conexao::pegarConexao();
            $sql = "UPDATE agenda SET data = :data, descricao = :descricao WHERE codigo = :codigo";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':data', $agenda->getData());
            $stmt->bindValue(':descricao', $agenda->getDescricao());
            $stmt->bindValue(':codigo', $agenda->getCodigo());

             if ($stmt->execute()) {
                 if ($stmt->rowCount() > 0) {
                     return json_encode(['sucesso' => true, 'mensagem' => 'Compromisso atualizado com sucesso!']);
                 } else {
                     return json_encode(['sucesso' => false, 'mensagem' => 'Nenhum compromisso encontrado com este código ou nenhum dado foi alterado.']);
                 }
            } else {
                // error_log("Erro SQL: " . implode(":", $stmt->errorInfo()));
                return json_encode(['sucesso' => false, 'mensagem' => 'Erro ao atualizar compromisso.']);
            }
        } catch (PDOException $e) {
            // error_log("Erro de Conexão/PDO: " . $e->getMessage());
            return json_encode(['sucesso' => false, 'mensagem' => 'Erro de banco de dados: ' . $e->getMessage()]);
        } finally {
             if ($con) {
               $con = null;
            }
        }
    }

    public function excluir($codigo) {
         $con = null;
        try {
            $con = Conexao::pegarConexao();
            $sql = "DELETE FROM agenda WHERE codigo = :codigo";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':codigo', $codigo);

             if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    return json_encode(['sucesso' => true, 'mensagem' => 'Compromisso excluído com sucesso!']);
                } else {
                    return json_encode(['sucesso' => false, 'mensagem' => 'Nenhum compromisso encontrado com este código para excluir.']);
                }
            } else {
                 // error_log("Erro SQL: " . implode(":", $stmt->errorInfo()));
                return json_encode(['sucesso' => false, 'mensagem' => 'Erro ao excluir compromisso.']);
            }
        } catch (PDOException $e) {
             // error_log("Erro de Conexão/PDO: " . $e->getMessage());
            return json_encode(['sucesso' => false, 'mensagem' => 'Erro de banco de dados: ' . $e->getMessage()]);
        } finally {
            if ($con) {
               $con = null;
            }
        }
    }
}
?>