<?php
require_once 'db.php';

$searchCompany = trim($_GET['company'] ?? '');

if ($searchCompany !== '') {
    $vacancies = findByCompany($pdo, $searchCompany);
} else {
    $stmt = $pdo->query("SELECT * FROM vacancies");
    $vacancies = $stmt->fetchAll();
}

$averageSalary = avgSalary($pdo);
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Каталог вакансій — Job Board</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <header class="header">
        <h1>Каталог IT-вакансій</h1>
        <p>Управління вакансіями через PDO/MySQL</p>
    </header>

    <div class="stats-grid">
        <div class="stat-box">
            <span class="stat-label">Середня зарплата на ринку</span>
            <span class="stat-value">$<?= number_format($averageSalary, 2, '.', '') ?></span>
        </div>
    </div>

    <section class="job-card section-block">
        <h2 class="section-title">Усі відкриті позиції</h2>
        
        <form method="get" class="search-form">
            <input type="text" name="company" class="form-control" placeholder="Пошук за компанією..." value="<?= htmlspecialchars($searchCompany) ?>">
            <button type="submit" class="btn-submit btn-inline">Знайти</button>
            <?php if ($searchCompany !== ''): ?>
                <a href="index.php" class="btn-submit btn-inline" style="background-color: #6b7280; text-decoration: none;">Скинути</a>
            <?php endif; ?>
        </form>

        <div style="margin-bottom: 20px;">
            <a href="add.php" class="btn-submit btn-inline" style="text-decoration: none; display: inline-block;">Додати вакансію</a>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Посада та компанія</th>
                        <th>Зарплатна вилка</th>
                        <th>Дії</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($vacancies as $v): ?>
                        <tr>
                            <td>
                                <strong><?= htmlspecialchars($v['title']) ?></strong>
                                <div class="text-muted"><?= htmlspecialchars($v['company']) ?></div>
                            </td>
                            <td class="salary-cell">
                                $<?= htmlspecialchars($v['salary_from']) ?> – $<?= htmlspecialchars($v['salary_to']) ?>
                            </td>
                            <td>
                                <a href="edit.php?id=<?= $v['id'] ?>" class="badge badge-active" style="text-decoration: none; margin-right: 8px;">Редагувати</a>
                                <a href="delete.php?id=<?= $v['id'] ?>" class="badge badge-expired" style="text-decoration: none;" onclick="return confirm('Підтвердити видалення?')">Видалити</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>
</body>
</html>