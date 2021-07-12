<?php
class User_tec
{
    private $pdo;
    public $msgErro = "";

    public function cadastrar_tec($siape, $nome, $data_nascimento, $cargo, $campus, $email, $senha)
    {
        global $pdo;
        
        //Verificar se já existe o siape cadastrado
        $sql = $pdo->prepare("SELECT id_tecnico FROM tecnico WHERE siape = :st");
        $sql->bindValue(":st", $siape);

        $sql->execute();

        $sql = $pdo->prepare("SELECT id_usuario FROM usuario WHERE email = :et");
        $sql->bindValue(":et", $email);

        $sql->execute();


        if($sql->rowCount() > 0)
        {
            return false;// ja cadastrada
        }
        else
        {
            //caso não, cadastrar na tabela usuario
            $sql = $pdo->prepare("INSERT INTO usuario (email, senha) VALUES (:et, :senha)");
            $sql->bindValue(":et",$email);
            $sql->bindValue(":senha",$senha);

            $sql->execute();
            $last_id = $pdo->lastInsertId();

            //tabela tecnico
            $sql = $pdo->prepare("INSERT INTO tecnico (siape, nome, data_nascimento, cargo, campus_id_campus, usuario_id_usuario) VALUES (:st, :nt, :dt_nasc, :ct, :camp, '.$last_id.')");
            $sql->bindValue(":st",$siape);
            $sql->bindValue(":nt",$nome);
            $sql->bindValue(":dt_nasc",$data_nascimento);
            $sql->bindValue(":ct",$cargo);
            $sql->bindValue(":camp",$campus);          

            $sql->execute();

            return true;
        }
    }
    
    public function logar_tec($email, $senha)
    {
        
        global $pdo;
        //verificar se o email e senha estão cadastrados
        
        $sql = $pdo->prepare("SELECT id_usuario FROM usuario WHERE email = :et AND senha = :senha");
        $sql->bindValue(":et",$email);

        $sql->bindValue(":senha",$senha);

        $sql->execute();
        //Se Sim
        if($sql->rowCount() > 0)
        {
            //entra no sistema (sessao)
            $dado =$sql->fetch();
            session_start();
            $_SESSION['id_usuario'] = $dado['id_usuario'];
            //$_SESSION['nome'] = $dado['nome'];

            return true; //logado com sucesso
        }
        else
        {
            return false; // não foi possivel logar
        }
    }
}
?>