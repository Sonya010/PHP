<?php
require_once 'db.php';
header('Content-Type: application/json');

$q = $_GET['q'] ?? '';

if ($q !== '') {
    $stmt = $pdo->prepare('SELECT * FROM vacancies WHERE company LIKE :q');
    $stmt->execute([':q' => "%$q%"]);
    $vacancies = $stmt->fetchAll();

    $stmtAvg = $pdo->prepare('SELECT AVG((salary_from + salary_to) / 2) AS avg_salary FROM vacancies WHERE company LIKE :q');
    $stmtAvg->execute([':q' => "%$q%"]);
    $avgResult = $stmtAvg->fetch();
} else {
    $stmt = $pdo->query('SELECT * FROM vacancies');
    $vacancies = $stmt->fetchAll();

    $stmtAvg = $pdo->query('SELECT AVG((salary_from + salary_to) / 2) AS avg_salary FROM vacancies');
    $avgResult = $stmtAvg->fetch();
}

$avgSalary = $avgResult['avg_salary'] ? (float)$avgResult['avg_salary'] : 0;

echo json_encode([
    'vacancies' => $vacancies,
    'avg_salary' => $avgSalary
]);