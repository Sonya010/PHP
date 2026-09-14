<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$jobs = [
    ['title' => 'Junior PHP Developer', 'company' => 'TechCorp', 'salaryFrom' => 800, 'salaryTo' => 1200, 'remote' => true],
    ['title' => 'Middle Frontend Engineer', 'company' => 'WebStudio', 'salaryFrom' => 1500, 'salaryTo' => 2500, 'remote' => false],
    ['title' => 'DevOps Engineer', 'company' => 'CloudNet', 'salaryFrom' => 2000, 'salaryTo' => 3500, 'remote' => true],
    ['title' => 'Project Manager', 'company' => 'BizSolutions', 'salaryFrom' => 1200, 'salaryTo' => 1800, 'remote' => false],
];

function formatJob(array $job): string {
    return "{$job['title']} <span class='company-name'>у компанії {$job['company']}</span>";
}

$totalSalaryFrom = 0;
foreach ($jobs as $job) {
    $totalSalaryFrom += $job['salaryFrom'];
}
$averageSalary = count($jobs) > 0 ? $totalSalaryFrom / count($jobs) : 0;
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог вакансій</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <h1>Каталог вакансій</h1>
            <p>Знайди роботу своєї мрії</p>
        </header>

        <div class="job-list">
            <?php foreach ($jobs as $job): ?>
                <?php 
                    if ($job['remote'] === true) {
                        $badgeClass = 'badge-remote';
                        $badgeText = 'Віддалено';
                    } else {
                        $badgeClass = 'badge-office';
                        $badgeText = 'В офісі';
                    }
                ?>
                <div class="job-card">
                    <div class="job-card-header">
                        <h2><?= formatJob($job) ?></h2>
                        <span class="badge <?= $badgeClass ?>"><?= $badgeText ?></span>
                    </div>
                    <div class="job-card-body">
                        <p class="salary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon"><rect x="2" y="6" width="20" height="12" rx="2"/><path d="M12 12h.01"/><path d="M17 12h.01"/><path d="M7 12h.01"/></svg>
                            Зарплата: <strong>$<?= $job['salaryFrom'] ?></strong> — <strong>$<?= $job['salaryTo'] ?></strong>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="aggregate-panel">
            <div class="aggregate-info">
                <h3>Аналітика ринку</h3>
                <p>Середня початкова зарплата:</p>
            </div>
            <div class="aggregate-value">
                $<?= round($averageSalary, 2) ?>
            </div>
        </div>
    </div>
</body>
</html>