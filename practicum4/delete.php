<?php
require_once 'db.php';
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('DELETE FROM vacancies WHERE id = :id');
    $stmt->execute([':id' => $_GET['id']]);
}
header('Location: index.php');
exit;