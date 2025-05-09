<?php
  include("modelPessoa.php");
  include("pessoa.php");

  $cpf = filter_input(INPUT_GET, "cpf");
  $nome = filter_input(INPUT_GET, "nome");
  $contato = filter_input(INPUT_GET, "contato");

  $pessoa = new Pessoa();
  $pessoa->setCpf($cpf);
  $pessoa->setNome($nome);
  $pessoa->setContato($contato);

  $modelPessoa = new modelPessoa();
  $modelPessoa->inserir($pessoa);
?>