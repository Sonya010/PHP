<?php
$dsn = 'mysql:host=localhost;dbname=practicum4;charset=utf8mb4';
$pdo = new PDO($dsn, 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);

function findByCompany($pdo, $company) {
    $stmt = $pdo->prepare('SELECT * FROM vacancies WHERE company = :company');
    $stmt->execute([':company' => $company]);
    return $stmt->fetchAll();
}

function avgSalary($pdo) {
    $stmt = $pdo->query('SELECT AVG((salary_from + salary_to) / 2) AS avg_salary FROM vacancies');
    $result = $stmt->fetch();
    return $result['avg_salary'] ? round($result['avg_salary'], 2) : 0;
}

function addVacancy($pdo, $title, $company, $salary_from, $salary_to) {
    $stmt = $pdo->prepare('INSERT INTO vacancies (title, company, salary_from, salary_to) VALUES (:title, :company, :salary_from, :salary_to)');
    return $stmt->execute([
        ':title' => $title,
        ':company' => $company,
        ':salary_from' => $salary_from,
        ':salary_to' => $salary_to
    ]);
}

function updateVacancy($pdo, $id, $title, $company, $salary_from, $salary_to) {
    $stmt = $pdo->prepare('UPDATE vacancies SET title = :title, company = :company, salary_from = :salary_from, salary_to = :salary_to WHERE id = :id');
    return $stmt->execute([
        ':title' => $title,
        ':company' => $company,
        ':salary_from' => $salary_from,
        ':salary_to' => $salary_to,
        ':id' => $id
    ]);
}

function deleteVacancy($pdo, $id) {
    $stmt = $pdo->prepare('DELETE FROM vacancies WHERE id = :id');
    return $stmt->execute([':id' => $id]);
}