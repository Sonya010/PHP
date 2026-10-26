<?php
require_once 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare('UPDATE vacancies SET title = :title, company = :company, salary_from = :salary_from, salary_to = :salary_to WHERE id = :id');
    $stmt->execute([
        ':title' => $_POST['title'],
        ':company' => $_POST['company'],
        ':salary_from' => $_POST['salary_from'],
        ':salary_to' => $_POST['salary_to'],
        ':id' => $_POST['id']
    ]);
    header('Location: index.php');
    exit;
}
$stmt = $pdo->prepare('SELECT * FROM vacancies WHERE id = :id');
$stmt->execute([':id' => $_GET['id']]);
$vacancy = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Редагувати вакансію</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <header class="header">
        <h1>Редагування вакансії</h1>
    </header>
    <section class="job-card section-block">
        <form method="post" style="display: flex; flex-direction: column; gap: 15px;">
            <input type="hidden" name="id" value="<?= htmlspecialchars($vacancy['id']) ?>">
            <label class="stat-label">Посада</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($vacancy['title']) ?>" required>
            <label class="stat-label">Компанія</label>
            <input type="text" name="company" class="form-control" value="<?= htmlspecialchars($vacancy['company']) ?>" required>
            <label class="stat-label">Зарплата від ($)</label>
            <input type="number" name="salary_from" class="form-control" value="<?= htmlspecialchars($vacancy['salary_from']) ?>" required>
            <label class="stat-label">Зарплата до ($)</label>
            <input type="number" name="salary_to" class="form-control" value="<?= htmlspecialchars($vacancy['salary_to']) ?>" required>
            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn-submit">Оновити</button>
                <a href="index.php" class="btn-submit" style="background-color: #6b7280; text-decoration: none; text-align: center;">Скасувати</a>
            </div>
        </form>
    </section>
</div>
</body>
</html>