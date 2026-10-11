<?php
declare(strict_types=1);

require_once __DIR__ . '/lib/functions.php';
require_once __DIR__ . '/classes/JobPosting.php';
require_once __DIR__ . '/classes/RemoteJobPosting.php';
require_once __DIR__ . '/classes/JobBoard.php';

$board = new JobBoard();

$job1 = new JobPosting('Junior PHP Developer', 'Genesis', 900, 1300, '2026-11-15');
$job2 = new RemoteJobPosting('Middle Backend Engineer (PHP/Symfony)', 'MacPaw', 2500, 3500, 'UTC+2 / UTC+3', '2026-12-01');
$job3 = new RemoteJobPosting('Full-Stack Web Developer', 'Grammarly', 3200, 4200, 'UTC-5 to UTC+2', '2026-10-25');
$job4 = new JobPosting('DevOps Engineer', 'Genesis', 2200, 3000, '2026-09-01');
$job5 = new RemoteJobPosting('QA Automation Engineer', 'Ajax Systems', 1500, 2100, 'UTC+2 (Kyiv)', '2026-11-30');

$board->addJob($job1);
$board->addJob($job2);
$board->addJob($job3);
$board->addJob($job4);
$board->addJob($job5);

$allJobs = $board->getAllJobs();
$averageSalary = $board->avgSalary();

$searchQuery = isset($_GET['company']) ? trim($_GET['company']) : 'Genesis';
$foundByCompany = $board->findByCompany($searchQuery);
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог IT-вакансій — Job Board</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <header class="header">
        <h1>Каталог IT-вакансій</h1>
        <p>Актуальні пропозиції роботи в технологічних компаніях</p>
    </header>

    <div class="stats-grid">
        <div class="stat-box">
            <span class="stat-label">Усього вакансій у базі</span>
            <span class="stat-value"><?= count($allJobs) ?></span>
        </div>
        <div class="stat-box">
            <span class="stat-label">Середня зарплата</span>
            <span class="stat-value">$<?= number_format($averageSalary, 2, '.', ' ') ?></span>
        </div>
    </div>

    <section class="job-card section-block">
        <h2 class="section-title">Усі відкриті позиції</h2>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Посада та компанія</th>
                        <th>Формат роботи</th>
                        <th>Зарплатна вилка</th>
                        <th>Статус</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allJobs as $job): ?>
                        <tr>
                            <td>
                                <strong><?= htmlspecialchars($job->getTitle()) ?></strong>
                                <div class="text-muted"><?= htmlspecialchars($job->getCompany()) ?></div>
                            </td>
                            <td>
                                <span class="type-pill <?= ($job instanceof RemoteJobPosting) ? 'pill-remote' : 'pill-office' ?>">
                                    <?= htmlspecialchars($job->getTypeLabel()) ?>
                                </span>
                            </td>
                            <td class="salary-cell">
                                <?= htmlspecialchars(formatSalaryRange($job->getSalaryFrom(), $job->getSalaryTo())) ?>
                            </td>
                            <td>
                                <?= renderStatusBadge($job->getExpiresAt()) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <section class="job-card section-block">
        <h2 class="section-title">Детальний огляд вакансій</h2>
        <ul class="info-list">
            <?php foreach ($allJobs as $job): ?>
                <li class="info-item">
                    <span><?= htmlspecialchars($job->getInfo()) ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>

    <section class="job-card section-block">
        <h2 class="section-title">Пошук вакансій за компанією</h2>
        <form method="GET" action="index.php" class="search-form">
            <input 
                type="text" 
                name="company" 
                class="form-control" 
                placeholder="Введіть назву компанії (напр. Genesis, MacPaw)..." 
                value="<?= htmlspecialchars($searchQuery) ?>"
            >
            <button type="submit" class="btn-submit btn-inline">Знайти</button>
        </form>

        <?php if (!empty($foundByCompany)): ?>
            <div class="alert alert-success">
                Знайдено вакансій для запиту «<strong><?= htmlspecialchars($searchQuery) ?></strong>»: <?= count($foundByCompany) ?>
            </div>
            <ul class="info-list">
                <?php foreach ($foundByCompany as $job): ?>
                    <li class="info-item">
                        <strong><?= htmlspecialchars($job->getInfo()) ?></strong>
                        <?= renderStatusBadge($job->getExpiresAt()) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="error-text">За запитом «<?= htmlspecialchars($searchQuery) ?>» вакансій не знайдено.</p>
        <?php endif; ?>
    </section>
</div>

</body>
</html>