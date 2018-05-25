<?php

require_once File::build_path(array('controller', 'ControllerMain.php'));
require_once File::build_path(array('controller', 'ControllerUser.php'));
require_once File::build_path(array('controller', 'ControllerSourceFin.php'));
require_once File::build_path(array('controller', 'ControllerDepartement.php'));
require_once File::build_path(array('controller', 'ControllerEntite.php'));
require_once File::build_path(array('controller', 'ControllerContact.php'));
require_once File::build_path(array('controller', 'ControllerParticipant.php'));
require_once File::build_path(array('controller', 'ControllerParticipation.php'));
require_once File::build_path(array('controller', 'ControllerImplication.php'));
require_once File::build_path(array('controller', 'ControllerProjet.php'));
require_once File::build_path(array('controller', 'ControllerDocument.php'));
require_once File::build_path(array('controller', 'ControllerNote.php'));
require_once File::build_path(array('controller', 'ControllerDeadLine.php'));

if (isset($_GET['controller'])) {
    $controller_class = 'Controller' . ucfirst($_GET['controller']);
} else {
    $controller_class = 'ControllerMain';
}

if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = 'home';
}

if (class_exists($controller_class)) {
    if (in_array($action, get_class_methods("$controller_class"))) {
        $controller_class::$action();
    } else {
        ControllerMain::erreur("Action inexistante");
    }
} else {
    ControllerMain::erreur("Controller inexistant");
}