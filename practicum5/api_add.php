<?php
require_once 'db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || empty($data['title']) || empty($data['company'])
    || !isset($data['salary_from'], $data['salary_to'])
    || !is_numeric($data['salary_from']) || !is_numeric($data['salary_to'])
    || (int)$data['salary_from'] > (int)$data['salary_to']) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid data']);
    exit;
}

$stmt = $pdo->prepare('INSERT INTO vacancies (title, company, salary_from, salary_to) VALUES (:title, :company, :salary_from, :salary_to)');
$stmt->execute([
    ':title' => $data['title'],
    ':company' => $data['company'],
    ':salary_from' => (int)$data['salary_from'],
    ':salary_to' => (int)$data['salary_to']
]);

$id = $pdo->lastInsertId();
http_response_code(201);
echo json_encode([
    'id' => (int)$id,
    'title' => $data['title'],
    'company' => $data['company'],
    'salary_from' => (int)$data['salary_from'],
    'salary_to' => (int)$data['salary_to']
]);