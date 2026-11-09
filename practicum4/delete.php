<?php
require_once 'db.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id) {
    deleteVacancy($pdo, $id);
}

header('Location: index.php');
exit;