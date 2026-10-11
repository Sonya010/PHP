<?php
declare(strict_types=1);

require_once __DIR__ . '/JobPosting.php';

class RemoteJobPosting extends JobPosting {
    private string $timezone;

    public function __construct(
        string $title,
        string $company,
        float $salaryFrom,
        float $salaryTo,
        string $timezone,
        string $expiresAt = '2026-12-31'
    ) {
        parent::__construct($title, $company, $salaryFrom, $salaryTo, $expiresAt);
        $this->timezone = $timezone;
    }

    public function getTimezone(): string {
        return $this->timezone;
    }

    public function getTypeLabel(): string {
        return 'Remote (' . $this->timezone . ')';
    }

    public function getInfo(): string {
        return parent::getInfo() . " | Формат: Віддалено (Часовий пояс: {$this->timezone})";
    }
}