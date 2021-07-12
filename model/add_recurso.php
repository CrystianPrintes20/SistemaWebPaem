<?php

class Add_recurso
{
    private $pdo;
    public $msgErro = "";

    public function adicionar_recurso($nome, $capacidade, $descricao, $hora_inicial, $hora_final,$campus,)
    {
        global $pdo;
        
        //Verificar se já existe o siape cadastrado
        $sql = $pdo->prepare("SELECT id_recurso_campus FROM recurso_campus WHERE nome = :nome && campus_id_campus = :camp");
        $sql->bindValue(":nome", $nome);
        $sql->bindValue(":camp", $campus);

        $sql->execute();


        if($sql->rowCount() > 0)
        {
            return false;// ja cadastrada
        }
        else
        {
         
            //insere na tabela
            $sql = $pdo->prepare("INSERT INTO recurso_campus (nome, capacidade, descricao, inicio_horario_funcionamento, fim_horario_funcionamento, campus_id_campus) VALUES (:nome, :capaci, :disc, :hi, :hf, :camp)");
            $sql->bindValue(":nome",$nome);
            $sql->bindValue(":capaci",$capacidade);
            $sql->bindValue(":disc",$descricao);
            $sql->bindValue(":hi",$hora_inicial);
            $sql->bindValue(":hf",$hora_final);
            $sql->bindValue(":camp",$campus);          

            $sql->execute();

            return true;
        }
    }
}
?>