<?php
// index sera o ponto central

require "src/classes/Tarefa.php";
require "src/classes/ArquivoTarefa.php";

// esta linha redireciona qualquer requisição no index para o endereco
// header('Location: /resource/lista_tarefas.html');

$escolha = $_POST['slc'] ? $_POST['slc'] : 1;

if(isset($_POST['slc'])){
    $escolha = $_POST['slc'];
}else{
    $escolha = 1;
}

$template = file_get_contents('resource/lista_tarefas.html');

$arquivoTarefa = new ArquivoTarefa('tarefas.json');
$listaTarefasJSON = $arquivoTarefa->le();

$modeloTarefa = file_get_contents('resource/tarefa.html');

$linhasTabela = '';


if ($escolha == 1){
    foreach ($listaTarefasJSON as $tarefa) {
        $tr = '';
        $tr = str_replace('#STATUS', $tarefa->legenda(), $modeloTarefa);
        $tr = str_replace('#ID',     $tarefa->getId(), $tr);
        $tr = str_replace('#NOME',  $tarefa->getNome(), $tr);
        $tr = str_replace('#DATALIMITE', $tarefa->getDataLimite(), $tr);
        $tr = str_replace('#MARCADO', $tarefa->getStatus() == 0 ? 'checked' : '', $tr);
        $tr = str_replace('#TODAS', $escolha == 1  ? 'selected' : '', $tr);
        $linhasTabela .= $tr;
    }
}

if ($escolha == 2){
    foreach ($listaTarefasJSON as $tarefa) {
        if ($tarefa->getStatus() == 0){
            $tr = '';
            $tr = str_replace('#STATUS', $tarefa->legenda(), $modeloTarefa);
            $tr = str_replace('#ID',     $tarefa->getId(), $tr);
            $tr = str_replace('#NOME',  $tarefa->getNome(), $tr);
            $tr = str_replace('#DATALIMITE', $tarefa->getDataLimite(), $tr);
            $tr = str_replace('#MARCADO', $tarefa->getStatus() == 0 ? 'checked' : '', $tr);
            $tr = str_replace('#ENCERRADAS', $escolha == 2  ? 'selected' : '', $tr);
            $linhasTabela .= $tr;
        }
    }
}

if ($escolha == 3){
    if ($tarefa->getStatus() == 1){
        $tr = '';
        $tr = str_replace('#STATUS', $tarefa->legenda(), $modeloTarefa);
        $tr = str_replace('#ID',     $tarefa->getId(), $tr);
        $tr = str_replace('#NOME',  $tarefa->getNome(), $tr);
        $tr = str_replace('#DATALIMITE', $tarefa->getDataLimite(), $tr);
        $tr = str_replace('#MARCADO', $tarefa->getStatus() == 0 ? 'checked' : '', $tr);
        $tr = str_replace('#ABERTAS', $escolha == 3  ? 'selected' : '', $tr);
        $linhasTabela .= $tr;
    }
}

// foreach ($listaTarefasJSON as $tarefa) {
//     $tr = '';
//     $tr = str_replace('#STATUS', $tarefa->legenda(), $modeloTarefa);
//     $tr = str_replace('#ID',     $tarefa->getId(), $tr);
//     $tr = str_replace('#NOME',  $tarefa->getNome(), $tr);
//     $tr = str_replace('#DATALIMITE', $tarefa->getDataLimite(), $tr);
//     $tr = str_replace('#MARCADO', $tarefa->getStatus() == 0 ? 'checked' : '', $tr);
//     $linhasTabela .= $tr;
// }

echo str_replace('#TAREFAS', $linhasTabela, $template);


