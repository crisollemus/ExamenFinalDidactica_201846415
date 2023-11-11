<?php
require_once 'Tarea.php';
require_once 'listaTareas.php';

session_start();

if (!isset($_SESSION['listaDeTareas'])) {
    $_SESSION['listaDeTareas'] = new ListaDeTareas();
}

if (!isset($_SESSION['tareasCompletadas'])) {
    $_SESSION['tareasCompletadas'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['agregarTarea'])) {
        $nombreTarea = $_POST['nombreTarea'];
        $prioridad = isset($_POST['prioridad']) ? $_POST['prioridad'] : null;
        $_SESSION['listaDeTareas']->agregarTarea($nombreTarea, $prioridad);
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}

if (isset($_POST['completarTarea'])) {
    $tareaIndex = $_POST['completarTarea'];
    $tarea = $_SESSION['listaDeTareas']->obtenerTareas()[$tareaIndex];
    $tarea->completar();
    $_SESSION['tareasCompletadas'][] = $tarea;
    $_SESSION['listaDeTareas']->eliminarTarea($tareaIndex);
}

if (isset($_POST['descompletarTarea'])) {
    $tareaIndex = $_POST['descompletarTarea'];
    $tarea = $_SESSION['tareasCompletadas'][$tareaIndex];
    $tarea->descompletar();
    $_SESSION['listaDeTareas']->agregarTarea($tarea->getNombre());
    unset($_SESSION['tareasCompletadas'][$tareaIndex]);
    $_SESSION['tareasCompletadas'] = array_values($_SESSION['tareasCompletadas']);
}

$tareas = $_SESSION['listaDeTareas']->obtenerTareas();
$tareasCompletadas = $_SESSION['tareasCompletadas'];
?>

<!DOCTYPE html>
<html>

<head>
    <title>Lista de Tareas</title>
    <link rel="stylesheet" href="style.css">
</head>

<style>
    body {
        background-image: url('images/efpem.png');
        background-color: lightblue;
        background-repeat: no-repeat;
        background-attachment: fixed;
    }
</style>

<body>
    <p style="color:white;">
        Universidad de San Carlos de Guatemala – USAC
        <br>
        Escuela de Formación de Profesores de Enseñanza Media – EFPEM
        <br>
        Didáctica de la Programación – 2023
    </p>
    <div class="container">
        <h1>Lista de Tareas</h1>
        <form method="post">
            <div class="task-item">
                <input type="text" name="nombreTarea" placeholder="Nueva tarea" required>
                <input type="number" name="prioridad" placeholder="Prioridad (opcional)">
                <button type="submit" name="agregarTarea">Agregar</button>
            </div>
        </form>

        <h2>Tareas Pendientes</h2>
<ul class="task-list">
    <?php foreach ($tareas as $index => $tarea) : ?>
        <li class="task-item">
            <!-- Nombre de la tarea -->
            <span class="<?php echo $tarea->estaCompletada() ? 'completed-task' : ''; ?>">
                <?php echo $tarea->getNombre(); ?>
            </span>
            <!-- Prioridad de la tarea (si es importante) -->
            <?php if ($tarea instanceof TareaImportante) : ?>
                <span>Prioridad: <?php echo $tarea->getPrioridad(); ?></span>
            <?php endif; ?>
            <!-- Botón para completar o descompletar la tarea -->
            <form method="post">
                <?php if (!$tarea->estaCompletada()) : ?>
                    <button type="submit" name="completarTarea" value="<?php echo $index; ?>">Completar</button>
                <?php else : ?>
                    <button type="submit" name="descompletarTarea" value="<?php echo $index; ?>">Descompletar</button>
                <?php endif; ?>
            </form>
        </li>
    <?php endforeach; ?>
</ul>
        <h2>Tareas Completadas</h2>
        <ul class="task-list">
            <?php foreach ($tareasCompletadas as $index => $tarea) : ?>
                <li class="task-item completed-task">
                    <span><?php echo $tarea->getNombre(); ?></span>
                    <form method="post">
                        <button type="submit" name="descompletarTarea" value="<?php echo $index; ?>">Descompletar</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <h1 style="color:white;" class="centrar_texto">Examen Final</h1>
    <table class="tabla_datos">
        <tr class="color_aqua centrar_texto">
            <td colspan="2">Datos Generales</td>
        </tr>
        <tr>
            <td class="columna1">Carné:</td>
            <td>201846415</td>
        </tr>
        <tr>
            <td>Nombre(s):</td>
            <td>Crisol Esmeralda</td>
        </tr>
        <tr>
            <td>Apellido(s):</td>
            <td>Garcia Lemus</td>
        </tr>
        <tr>
            <td>Fecha:</td>
            <td>11/02/2023</td>
        </tr>

    </table>


    <br>
    <img src="images/Usac_logo.png" class="logo_usac">

    </div>
    </div>
</body>
<footer class="centrar_texto" style="color:white"> Id y Enseñad a Todos"</footer>

</html>