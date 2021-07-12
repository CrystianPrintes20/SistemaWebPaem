<?php
include 'proc_pesq_user.php';


class Reserva{
    public $msgErro = "";


    public function reservar_espaco($espaco_sala, $data_reserva, $horario, $matricula)
    {
        global $pdo;
        
        $sql = "SELECT id_discente FROM discente WHERE matricula =  $matricula";
        $result = $pdo->query( $sql );
        $id_discente = $result->fetch()[0]; //como é um array, entao pego apenas o primeiro incide que é o numero do id do discente.

        $hi = ($horario[0]);
        $hf = ($horario[1]);
      
        //
        //$hi_hf1 = str_split($hi_hf, 6);
        //print_r($hi_hf1[0]);

        //Verificar se já existe reversa desse aluno para essa sala
        $sql = $pdo->prepare("SELECT id_solicitacao_acesso FROM solicitacao_acesso WHERE id_recurso_campus = :i_r_c AND discente_id_discente = :d_i_d AND hora_inicio = :hi AND hora_fim = :hf");
        $sql->bindValue(":i_r_c", $espaco_sala);
        $sql->bindValue(":d_i_d", $id_discente);
        $sql->bindValue(":hi", $hi);
        $sql->bindValue(":hf", $hf);
        $sql->execute();

        if($sql->rowCount() > 0)
        {
            return false;// ja cadastrada
        }
        else
        {
              //caso não, cadastrar na tabela solicitacao_acesso
            $sql = $pdo->prepare("INSERT INTO solicitacao_acesso (id_recurso_campus, data, hora_inicio, hora_fim, discente_id_discente) VALUES (:i_r_c, :dt_reser, :hi, :hf, :d_i_d)");
            $sql->bindValue(":i_r_c",$espaco_sala);
            $sql->bindValue(":dt_reser", $data_reserva);
            $sql->bindValue(":hi",$hi);
            $sql->bindValue(":hf",$hf);
            $sql->bindValue(":d_i_d",$id_discente);

            $sql->execute();

            return true;
     
        }
    }
}
?>