<?php
$admin_id = $_SESSION['user_id'];


?>

<div class="container mt-3">
    <a href="edit_training.php" class="btn btn-primary">Novo treino</a>
</div>
<hr>
<?php
$treinos_cadastrados = $conn->query("SELECT training.*, users.name as user_name FROM training JOIN users ON training.user_id = users.id WHERE training.admin_id = '$admin_id'");
?>
<h1>Treino cadastrados</h1>
<?php
if ($result->num_rows > 0):
    while ($row = $treinos_cadastrados->fetch_assoc()):
        ?>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Aluno</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                echo '<tr>';
                echo '<td>' . $row['user_name'] . '</td>';
                echo '<td>' . $row['name'] . '</td>';
                echo '<td>' . $row['description'] . '</td>';
                echo '<td>';
                echo '<a href="util/delete_training.php?id=' . $row['id'] . '" class="btn btn-danger">Excluir</a>';
                echo '<a href="edit_training.php?id=' . $row['id'] . '" class="btn btn-primary">Editar</a>';
                echo '</td>';
                echo '</tr>';

                echo '<tr>';
                echo '<td colspan="4" style="background-color: #32383f;">';
                echo '<table class="table_exercise table table-bordered table-sm mb-0" width="100%">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Exercício</th>';
                echo '<th>Séries</th>';
                echo '<th>Repetições</th>';
                echo '<th>Carga (kg)</th>';
                echo '<th>Descrição</th>';
                echo '<th>Nível</th>';
                echo '</tr>';
                echo '</thead>';

                $training_id = $row['id'];
                $exercicios_do_treino = $conn->query("SELECT training_exercise.*, exercise.name as exercise_name, exercise.description as exercise_description, exercise.level as exercise_level FROM training_exercise JOIN exercise ON training_exercise.exercise_id = exercise.id WHERE training_id = $training_id");
                echo '<tbody>';
                while ($exercise = $exercicios_do_treino->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $exercise['exercise_name'] . '</td>';
                    echo '<td>' . $exercise['sets'] . '</td>';
                    echo '<td>' . $exercise['repetitions'] . '</td>';
                    echo '<td>' . $exercise['load'] . '</td>';
                    echo '<td>' . $exercise['exercise_description'] . '</td>';
                    echo '<td>' . $exercise['exercise_level'] . '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
                echo '</td>';
                echo '</tr>';


                ?>
            </tbody>
        </table>
        <?php
    endwhile;
endif;

?>