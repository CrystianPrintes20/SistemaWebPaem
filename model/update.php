<?php

class User_tec
{
    private $pdo;
    public $msgErro = "";

    public function cadastrar_tec($siape, $nome, $data_nascimento, $cargo, $campus, $email, $senha, $id)
    {
        global $pdo;

            // cadastrar na tabela usuario
            $sql = $pdo->prepare("UPDATE usuario SET email = :et, senha = :senha WHERE id_usuario = $id");
            $sql->bindValue(":et",$email);
            $sql->bindValue(":senha",$senha);

            $sql->execute();


            //tabela tecnico
            $sql = $pdo->prepare("UPDATE tecnico SET siape = :st, nome = :nt, data_nascimento = :dt_nasc, cargo = :ct, campus_id_campus = :camp WHERE usuario_id_usuario = $id");
            $sql->bindValue(":st",$siape);
            $sql->bindValue(":nt",$nome);
            $sql->bindValue(":dt_nasc",$data_nascimento);
            $sql->bindValue(":ct",$cargo);
            $sql->bindValue(":camp",$campus);          

            $sql->execute();

            return true;
    }
}
?>