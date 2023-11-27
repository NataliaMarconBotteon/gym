<?php
session_start();

require_once(__DIR__ . '/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome_treino = $_POST['name'];
    $descricao_treino = $_POST['description'];
    $user_id = $_POST['user_id'];
    $admin_id = $_SESSION['user_id'];

    if (isset($_POST['edit_training_id'])) {
        $edit_training_id = $_POST['edit_training_id'];
        $sql_treino = "UPDATE training SET name = '$nome_treino', description = '$descricao_treino', user_id = '$user_id' WHERE id = '$edit_training_id'";

    } else {
        $sql_treino = "INSERT INTO training (name, description, user_id, admin_id) VALUES ('$nome_treino', '$descricao_treino', '$user_id', '$admin_id')";

    }

    if ($conn->query($sql_treino) === FALSE) {
        echo "Erro ao cadastrar treino: " . $conn->error;
        exit();
    }

    $training_id = $conn->insert_id;


    for ($i = 1; $i <= 2; $i++) {
        $sets = (int) $_POST["sets$i"];
        $repetitions = (int) $_POST["repetitions$i"];
        $load = (float) $_POST["load$i"];
        $exercise_id = (int) $_POST["exercise$i"];

        if (isset($_POST['edit_training_id'])) {
            $exercise_training_id = (int) $_POST["exercise_training_{$i}_id"];
            $sql_exercise = "UPDATE training_exercise SET `exercise_id` = $exercise_id, `sets` = $sets, `repetitions` = $repetitions, `load` = $load WHERE id = $exercise_training_id;";

        } else {
            $sql_exercise = "INSERT INTO training_exercise (`sets`, `repetitions`, `load`, `training_id`, `exercise_id`) 
                          VALUES ($sets, $repetitions, $load, $training_id, $exercise_id)";
        }


        if ($conn->query($sql_exercise) !== TRUE) {
            echo "Erro ao cadastrar exercício: " . $conn->error;
            exit();
        }
    }

    $conn->close();

    header("Location: ../dashboard.php");
} else {
    header("Location: ../index.php");
    exit();
}
?>