<?php
require_once 'db.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $title = trim($_POST['title'] ?? '');
    $company = trim($_POST['company'] ?? '');
    $salary_from = filter_input(INPUT_POST, 'salary_from', FILTER_VALIDATE_INT);
    $salary_to = filter_input(INPUT_POST, 'salary_to', FILTER_VALIDATE_INT);

    if (!$id || empty($title) || empty($company) || $salary_from === false || $salary_to === false) {
        $error = 'Будь ласка, заповніть усі поля коректно.';
    } elseif ($salary_from > $salary_to) {
        $error = 'Мінімальна зарплата не може бути більшою за максимальну.';
    } else {
        updateVacancy($pdo, $id, $title, $company, $salary_from, $salary_to);
        header('Location: index.php');
        exit;
    }
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM vacancies WHERE id = :id');
$stmt->execute([':id' => $id]);
$vacancy = $stmt->fetch();

if (!$vacancy) {
    header('Location: index.php');
    exit;
}
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
        <?php if ($error): ?>
            <div class="alert badge-expired" style="margin-bottom: 15px;"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post" style="display: flex; flex-direction: column; gap: 15px;">
            <input type="hidden" name="id" value="<?= htmlspecialchars($vacancy['id']) ?>">
            <label class="stat-label">Посада</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($_POST['title'] ?? $vacancy['title']) ?>" required>
            <label class="stat-label">Компанія</label>
            <input type="text" name="company" class="form-control" value="<?= htmlspecialchars($_POST['company'] ?? $vacancy['company']) ?>" required>
            <label class="stat-label">Зарплата від ($)</label>
            <input type="number" name="salary_from" class="form-control" value="<?= htmlspecialchars($_POST['salary_from'] ?? $vacancy['salary_from']) ?>" required>
            <label class="stat-label">Зарплата до ($)</label>
            <input type="number" name="salary_to" class="form-control" value="<?= htmlspecialchars($_POST['salary_to'] ?? $vacancy['salary_to']) ?>" required>
            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn-submit">Оновити</button>
                <a href="index.php" class="btn-submit" style="background-color: #6b7280; text-decoration: none; text-align: center;">Скасувати</a>
            </div>
        </form>
    </section>
</div>
</body>
</html>