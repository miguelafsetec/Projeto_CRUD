<?php
// Sempre retornar JSON
header('Content-Type: application/json; charset=utf-8');

include_once("modelAgenda.php");
include_once("Agenda.php");

$acao = $_REQUEST['acao'] ?? ''; // Usar $_REQUEST para pegar GET ou POST
$metodo = $_SERVER['REQUEST_METHOD']; // Pega o método HTTP (GET, POST, PUT, DELETE)

$model = new ModelAgenda();
$agenda = new Agenda();
$resposta = ['sucesso' => false, 'mensagem' => 'Ação inválida ou não fornecida.']; // Resposta padrão

// --- ROTAS ---

// CONSULTAR (READ) - Método GET
if ($metodo === 'GET' && $acao === 'consultar') {
    $codigo = $_GET['codigo'] ?? null; // Permite buscar um código específico
    $dados = $model->consultar($codigo);
    // Se a consulta no modelo retornar um array com 'erro', repassa como resposta de falha
    if (is_array($dados) && isset($dados['erro'])) {
         $resposta = ['sucesso' => false, 'mensagem' => $dados['erro'], 'dados' => null];
    } else {
        // Se for uma consulta por código e não encontrar, $dados será false
        if ($codigo && $dados === false) {
             $resposta = ['sucesso' => false, 'mensagem' => 'Compromisso não encontrado.', 'dados' => null];
        } else {
            // Se for consulta geral ou encontrou por código
             $resposta = ['sucesso' => true, 'mensagem' => 'Consulta realizada com sucesso.', 'dados' => $dados];
        }
    }
    echo json_encode($resposta, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT); // Pretty print para facilitar leitura
    exit; // Termina o script após a consulta
}

// INSERIR (CREATE) - Método POST
if ($metodo === 'POST' && $acao === 'inserir') {
    // Pegar dados do corpo da requisição POST (esperando JSON)
    $dadosRecebidos = json_decode(file_get_contents('php://input'), true);

    if ($dadosRecebidos && isset($dadosRecebidos['cpf'], $dadosRecebidos['data'], $dadosRecebidos['descricao'])) {
        $agenda->setCpf($dadosRecebidos['cpf']);
        $agenda->setData($dadosRecebidos['data']);
        $agenda->setDescricao($dadosRecebidos['descricao']);
        // A resposta do método inserir já é JSON
        echo $model->inserir($agenda);

    } else {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Dados incompletos para inserir. Envie cpf, data e descricao no corpo JSON.']);
    }
    exit;
}

// ATUALIZAR (UPDATE) - Método POST (ou PUT, mas POST é mais simples com HTML forms)
if ($metodo === 'POST' && $acao === 'atualizar') {
     $dadosRecebidos = json_decode(file_get_contents('php://input'), true);

    if ($dadosRecebidos && isset($dadosRecebidos['codigo'], $dadosRecebidos['data'], $dadosRecebidos['descricao'])) {
        $agenda->setCodigo($dadosRecebidos['codigo']);
        $agenda->setData($dadosRecebidos['data']); // Data para atualizar
        $agenda->setDescricao($dadosRecebidos['descricao']); // Descrição para atualizar
         // CPF não é atualizado aqui intencionalmente
        echo $model->atualizar($agenda); // Retorna JSON
    } else {
         echo json_encode(['sucesso' => false, 'mensagem' => 'Dados incompletos para atualizar. Envie codigo, data e descricao no corpo JSON.']);
    }
    exit;
}

// EXCLUIR (DELETE) - Método POST (ou DELETE)
if ($metodo === 'POST' && $acao === 'excluir') { // Poderia ser DELETE, mas POST simplifica o HTML
    $dadosRecebidos = json_decode(file_get_contents('php://input'), true);

    if ($dadosRecebidos && isset($dadosRecebidos['codigo'])) {
        echo $model->excluir($dadosRecebidos['codigo']); // Retorna JSON
    } else {
         echo json_encode(['sucesso' => false, 'mensagem' => 'Código do compromisso não fornecido para exclusão no corpo JSON.']);
    }
    exit;
}

// Se nenhuma rota correspondeu
http_response_code(400); // Bad Request
echo json_encode($resposta, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

?>