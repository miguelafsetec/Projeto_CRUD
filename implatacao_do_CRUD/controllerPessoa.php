<?php
  include("modelPessoa.php");
  include("pessoa.php");

  $cpf = filter_input(INPUT_GET, "cpf");
  $nome = filter_input(INPUT_GET, "nome");
  $contato = filter_input(INPUT_GET, "contato");
  $acao = filter_input(INPUT_GET, "acao");  

  $pessoa = new Pessoa();
  $pessoa->setCpf($cpf);
  $pessoa->setNome($nome);
  $pessoa->setContato($contato);

  $modelPessoa = new modelPessoa();
  
  if($acao=="inserir"){
      $modelPessoa->inserir($pessoa);
  }else if($acao=="apagar"){
      $modelPessoa->apagar($pessoa);
  }else if($acao=="atualizar"){
    $modelPessoa->atualizar($pessoa);
  }else if($acao=="consultar"){
    echo $modelPessoa->consultar();
  }
?>