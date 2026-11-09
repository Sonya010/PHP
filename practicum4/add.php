<?php
require_once 'db.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $company = trim($_POST['company'] ?? '');
    $salary_from = filter_input(INPUT_POST, 'salary_from', FILTER_VALIDATE_INT);
    $salary_to = filter_input(INPUT_POST, 'salary_to', FILTER_VALIDATE_INT);

    if (empty($title) || empty($company) || $salary_from === false || $salary_to === false) {
        $error = 'Будь ласка, заповніть усі поля коректно.';
    } elseif ($salary_from > $salary_to) {
        $error = 'Мінімальна зарплата не може бути більшою за максимальну.';
    } else {
        addVacancy($pdo, $title, $company, $salary_from, $salary_to);
        header('Location: index.php');
        exit;
    }
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
        <?php if ($error): ?>
            <div class="alert badge-expired" style="margin-bottom: 15px;"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post" style="display: flex; flex-direction: column; gap: 15px;">
            <input type="text" name="title" class="form-control" required placeholder="Посада (напр. PHP Developer)" value="<?= htmlspecialchars($_POST['title'] ?? '') ?>">
            <input type="text" name="company" class="form-control" required placeholder="Компанія" value="<?= htmlspecialchars($_POST['company'] ?? '') ?>">
            <input type="number" name="salary_from" class="form-control" required placeholder="Зарплата від ($)" value="<?= htmlspecialchars($_POST['salary_from'] ?? '') ?>">
            <input type="number" name="salary_to" class="form-control" required placeholder="Зарплата до ($)" value="<?= htmlspecialchars($_POST['salary_to'] ?? '') ?>">
            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn-submit">Зберегти</button>
                <a href="index.php" class="btn-submit" style="background-color: #6b7280; text-decoration: none; text-align: center;">Скасувати</a>
            </div>
        </form>
    </section>
</div>
</body>
</html>