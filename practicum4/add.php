<?php
require_once 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare('INSERT INTO vacancies (title, company, salary_from, salary_to) VALUES (:title, :company, :salary_from, :salary_to)');
    $stmt->execute([
        ':title' => $_POST['title'],
        ':company' => $_POST['company'],
        ':salary_from' => $_POST['salary_from'],
        ':salary_to' => $_POST['salary_to']
    ]);
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Додати вакансію</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <header class="header">
        <h1>Створення вакансії</h1>
    </header>
    <section class="job-card section-block">
        <form method="post" style="display: flex; flex-direction: column; gap: 15px;">
            <input type="text" name="title" class="form-control" required placeholder="Посада (напр. PHP Developer)">
            <input type="text" name="company" class="form-control" required placeholder="Компанія">
            <input type="number" name="salary_from" class="form-control" required placeholder="Зарплата від ($)">
            <input type="number" name="salary_to" class="form-control" required placeholder="Зарплата до ($)">
            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn-submit">Зберегти</button>
                <a href="index.php" class="btn-submit" style="background-color: #6b7280; text-decoration: none; text-align: center;">Скасувати</a>
            </div>
        </form>
    </section>
</div>
</body>
</html>