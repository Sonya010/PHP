<?php
declare(strict_types=1);

require_once __DIR__ . '/../lib/functions.php';

class JobPosting {
    protected string $title;
    protected string $company;
    protected float $salaryFrom;
    protected float $salaryTo;
    private string $expiresAt;

    public function __construct(
        string $title,
        string $company,
        float $salaryFrom,
        float $salaryTo,
        string $expiresAt = '2026-12-31'
    ) {
        $this->title = $title;
        $this->company = $company;
        $this->salaryFrom = $salaryFrom;
        $this->salaryTo = $salaryTo;
        $this->expiresAt = $expiresAt;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getCompany(): string {
        return $this->company;
    }

    public function getSalaryFrom(): float {
        return $this->salaryFrom;
    }

    public function getSalaryTo(): float {
        return $this->salaryTo;
    }

    public function getExpiresAt(): string {
        return $this->expiresAt;
    }

    public function getTypeLabel(): string {
        return 'Офіс / Гібрид';
    }

    public function getInfo(): string {
        $salary = formatSalaryRange($this->salaryFrom, $this->salaryTo);
        return "{$this->title} у компанії «{$this->company}» | Зарплата: {$salary}";
    }
}