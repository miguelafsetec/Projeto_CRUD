<?php
require_once("modelAgenda.php");

$acao = $_GET["acao"] ?? "";

$model = new ModelAgenda();

switch ($acao) {
    case "inserir":
        $agenda = new Agenda();
        $agenda->setCpf($_GET["cpf"]);
        $agenda->setData($_GET["data"]);
        $agenda->setDescricao($_GET["descricao"]);
        $model->inserir($agenda);
        echo "Compromisso inserido!";
        break;

    case "atualizar":
        $agenda = new Agenda();
        $agenda->setCodigo($_GET["codigo"]);
        $agenda->setCpf($_GET["cpf"]);
        $agenda->setData($_GET["data"]);
        $agenda->setDescricao($_GET["descricao"]);
        $model->atualizar($agenda);
        echo "Compromisso atualizado!";
        break;

    case "apagar":
        $model->apagar($_GET["codigo"]);
        echo "Compromisso apagado!";
        break;

    case "consultar":
        echo json_encode($model->consultar());
        break;
}
?>
