<?php
$errors = [];
$successMessage = '';

$title = trim($_POST['title'] ?? '');
$company = trim($_POST['company'] ?? '');
$salaryFrom = trim($_POST['salaryFrom'] ?? '');
$salaryTo = trim($_POST['salaryTo'] ?? '');
$remote = isset($_POST['remote']) ? true : false; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if ($title === '') {
        $errors['title'] = 'Назва вакансії є обов\'язковою.';
    }
    
    if ($company === '') {
        $errors['company'] = 'Назва компанії є обов\'язковою.';
    }

    if ($salaryFrom === '' || !is_numeric($salaryFrom) || $salaryFrom < 0) {
        $errors['salaryFrom'] = 'Початкова зарплата має бути додатним числом.';
    }

    if ($salaryTo === '' || !is_numeric($salaryTo) || $salaryTo < 0) {
        $errors['salaryTo'] = 'Кінцева зарплата має бути додатним числом.';
    } elseif (is_numeric($salaryFrom) && $salaryTo < $salaryFrom) {
        $errors['salaryTo'] = 'Кінцева зарплата не може бути меншою за початкову.';
    }

    if (empty($errors)) {
        $successMessage = "Вакансію «" . htmlspecialchars($title) . "» у компанії «" . htmlspecialchars($company) . "» успішно додано!";
        $title = $company = $salaryFrom = $salaryTo = '';
        $remote = false;
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Додавання вакансії</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <h1>Каталог вакансій</h1>
            <p>Додавання нової вакансії</p>
        </header>

        <?php if ($successMessage): ?>
            <div class="alert alert-success">
                <?= $successMessage ?>
            </div>
        <?php endif; ?>

        <form method="post" action="form.php" id="jobForm" class="job-card">
            
            <div class="form-group">
                <label for="title">Назва вакансії (Title):</label>
                <input type="text" id="title" name="title" class="form-control" 
                       value="<?= htmlspecialchars($title) ?>" required>
                <?php if (isset($errors['title'])): ?>
                    <span class="error-text"><?= $errors['title'] ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="company">Компанія (Company):</label>
                <input type="text" id="company" name="company" class="form-control" 
                       value="<?= htmlspecialchars($company) ?>" required>
                <?php if (isset($errors['company'])): ?>
                    <span class="error-text"><?= $errors['company'] ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="salaryFrom">Зарплата від (Salary From), $:</label>
                <input type="number" id="salaryFrom" name="salaryFrom" class="form-control" 
                       value="<?= htmlspecialchars($salaryFrom) ?>" min="0" required>
                <?php if (isset($errors['salaryFrom'])): ?>
                    <span class="error-text"><?= $errors['salaryFrom'] ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="salaryTo">Зарплата до (Salary To), $:</label>
                <input type="number" id="salaryTo" name="salaryTo" class="form-control" 
                       value="<?= htmlspecialchars($salaryTo) ?>" min="0" required>
                <?php if (isset($errors['salaryTo'])): ?>
                    <span class="error-text" id="serverErrorTo"><?= $errors['salaryTo'] ?></span>
                <?php endif; ?>
                <span class="error-text" id="jsErrorTo" style="display: none;"></span>
            </div>

            <div class="checkbox-group">
                <input type="checkbox" id="remoteFilter" name="remote" <?= $remote ? 'checked' : '' ?>>
                <label for="remoteFilter" style="margin-bottom: 0;">Тільки віддалені (Remote)</label>
            </div>

            <button type="submit" class="btn-submit">Додати вакансію</button>
        </form>
    </div>

    <script>
        const form = document.getElementById('jobForm');
        form.addEventListener('submit', function(event) {
            const salaryFrom = parseFloat(document.getElementById('salaryFrom').value);
            const salaryTo = parseFloat(document.getElementById('salaryTo').value);
            const jsErrorTo = document.getElementById('jsErrorTo');
            const serverErrorTo = document.getElementById('serverErrorTo');

            if (!isNaN(salaryFrom) && !isNaN(salaryTo) && salaryTo < salaryFrom) {
                event.preventDefault(); 
                
                jsErrorTo.textContent = 'Помилка: Кінцева зарплата не може бути меншою за початкову.';
                jsErrorTo.style.display = 'block';
                
                if (serverErrorTo) {
                    serverErrorTo.style.display = 'none';
                }
            } else {
                jsErrorTo.style.display = 'none';
            }
        });

        const remoteCheckbox = document.getElementById('remoteFilter');
        

        <?php if ($_SERVER['REQUEST_METHOD'] !== 'POST'): ?>
            const savedRemoteState = localStorage.getItem('remote_filter_checked');
            if (savedRemoteState !== null) {
                remoteCheckbox.checked = JSON.parse(savedRemoteState);
            }
        <?php endif; ?>

        remoteCheckbox.addEventListener('change', function() {
            localStorage.setItem('remote_filter_checked', JSON.stringify(this.checked));
        });
    </script>
</body>
</html>