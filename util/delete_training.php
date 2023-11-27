<?php

require_once(__DIR__ . '/db.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $treino_id = $_GET['id'];

    $verifica_treino = $conn->query("SELECT * FROM training WHERE id = $treino_id");

    if ($verifica_treino->num_rows > 0) {
        $sql_excluir_training_exercise = "DELETE FROM training_exercise WHERE training_id = $treino_id";
        $sql_excluir_treino = "DELETE FROM training WHERE id = $treino_id";
        
        if ($conn->query($sql_excluir_training_exercise) === TRUE && $conn->query($sql_excluir_treino) === TRUE) {
            header("Location: ../dashboard.php");
            exit();
        } else {
            echo "Erro ao excluir treino: " . $conn->error;
        }
    } else {
        echo "Treino não encontrado.";
    }
} else {
    header("Location: sua_pagina_anterior.php");
    exit();
}

$conn->close();
?>
