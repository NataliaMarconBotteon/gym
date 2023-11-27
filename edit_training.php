<?php
session_start();

require_once('util/db.php');
include('util/header.php');

$admin_id = $_SESSION['user_id'];

$edit_training_id = isset($_GET['id']) ? $_GET['id'] : null;

$training_details = [];
if ($edit_training_id) {
    $edit_query = $conn->query("SELECT * FROM training WHERE id = '$edit_training_id'");
    $training_details = $edit_query->fetch_assoc();
}

?>

<?php
$alunos_cadastrados = $conn->query("SELECT id, name FROM users WHERE type = 'client'")->fetch_all();
?>
<h1>Cadastrar novo treino</h1>
<div class="container mt-5">
    <form action="util/processa_formulario.php" method="POST">
        <?php
        if ($edit_training_id) {
            echo '<input type="hidden" name="edit_training_id" value="' . $edit_training_id . '">';
        }
        ?>
        <div class="mb-3">
            <label for="name" class="form-label">Nome do Treino:</label>
            <input type="text" class="form-control" id="name" name="name" required
                value="<?php echo $training_details['name'] ?? ''; ?>">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descrição do Treino:</label>
            <textarea class="form-control" id="description" name="description" rows="3"
                required><?php echo $training_details['description'] ?? ''; ?></textarea>
        </div>


        <div class="mb-3">
            <label for="user_id" class="form-label">ID do Usuário:</label>
            <select class="form-select" id="alunoSelect" name="user_id">
                <option value="" selected disabled>Selecione um aluno</option>
                <?php
                foreach ($alunos_cadastrados as $aluno) {
                    $selected = ($training_details['user_id'] ?? '') == $aluno[0] ? 'selected' : '';
                    echo '<option value="' . $aluno[0] . '" ' . $selected . '>' . $aluno[1] . '</option>';
                }
                ?>
            </select>
        </div>

        <hr style="border: 2px solid #fff; margin: 30px 0; height: 3px;">

        <?php
        $exercicios_cadastrados = $conn->query("SELECT id, name FROM exercise")->fetch_all();

        if ($edit_training_id) {
            $exercicios_do_treino = $conn->query("SELECT * FROM training_exercise WHERE training_id = $edit_training_id");
            $exercise1 = $exercicios_do_treino->fetch_assoc();
            $exercise2 = $exercicios_do_treino->fetch_assoc();
        }
        ?>

        <?php
        if ($edit_training_id) {
            echo '<input type="hidden" name="exercise_training_1_id" value="' . $exercise1['id'] . '">';
            echo '<input type="hidden" name="exercise_training_2_id" value="' . $exercise2['id'] . '">';
        }
        ?>

        <div class="mb-3">
            <label for="exercise1" class="form-label">Exercício 1</label>
            <select name="exercise1" id="exercise1" class="form-select">
                <option selected></option>
                <?php
                foreach ($exercicios_cadastrados as $exercise) {
                    $selected = ($exercise1['exercise_id'] ?? '') == $exercise[0] ? 'selected' : '';
                    echo '<option value="' . $exercise[0] . '" ' . $selected . '>' . $exercise[1] . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="row g-3 mb-3">

            <div class="col-md-4">
                <label for="sets1" class="form-label">Séries</label>
                <input name="sets1" type="text" class="form-control" id="sets1"
                    value="<?php echo $exercise1['sets'] ?? ''; ?>">
            </div>
            <div class="col-md-4">
                <label for="repetitions1" class="form-label">Repetições</label>
                <input name="repetitions1" type="text" class="form-control" id="repetitions1"
                    value="<?php echo $exercise1['repetitions'] ?? ''; ?>">
            </div>
            <div class="col-md-4">
                <label for="load1" class="form-label">Carga</label>
                <input name="load1" type="text" class="form-control" id="load1"
                    value="<?php echo $exercise1['load'] ?? ''; ?>">
            </div>
        </div>


        <hr style="border: 2px solid #fff; margin: 30px 0; height: 3px;">
        <div class="mb-3">
            <label for="exercise2" class="form-label">Exercício 2</label>
            <select name="exercise2" id="exercise2" class="form-select">
                <option selected></option>
                <?php
                foreach ($exercicios_cadastrados as $exercise) {
                    $selected = ($exercise2['exercise_id'] ?? '') == $exercise[0] ? 'selected' : '';
                    echo '<option value="' . $exercise[0] . '" ' . $selected . '>' . $exercise[1] . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="row g-3 mb-3">

            <div class="col-md-4">
                <label for="sets2" class="form-label">Séries</label>
                <input name="sets2" type="text" class="form-control" id="sets2"
                    value="<?php echo $exercise2['sets'] ?? ''; ?>">
            </div>
            <div class="col-md-4">
                <label for="repetitions2" class="form-label">Repetições</label>
                <input name="repetitions2" type="text" class="form-control" id="repetitions2"
                    value="<?php echo $exercise2['repetitions'] ?? ''; ?>">
            </div>
            <div class="col-md-4">
                <label for="load2" class="form-label">Carga</label>
                <input name="load2" type="text" class="form-control" id="load2"
                    value="<?php echo $exercise2['load'] ?? ''; ?>">
            </div>
        </div>


        <button type="submit" class="btn btn-primary">Cadastrar Treino</button>
    </form>
</div>
<?php
include('util/footer.php');
?>