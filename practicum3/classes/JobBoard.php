<?php
declare(strict_types=1);

require_once __DIR__ . '/JobPosting.php';

class JobBoard {
    private array $jobs = [];

    public function addJob(JobPosting $job): void {
        $this->jobs[] = $job;
    }

    public function getAllJobs(): array {
        return $this->jobs;
    }

    public function findByCompany(string $company): array {
        $result = [];
        foreach ($this->jobs as $job) {
            if (mb_stripos($job->getCompany(), $company) !== false) {
                $result[] = $job;
            }
        }
        return $result;
    }

    public function avgSalary(): float {
        if (empty($this->jobs)) {
            return 0.0;
        }

        $totalMidpoint = 0.0;
        foreach ($this->jobs as $job) {
            $midpoint = ($job->getSalaryFrom() + $job->getSalaryTo()) / 2;
            $totalMidpoint += $midpoint;
        }

        return round($totalMidpoint / count($this->jobs), 2);
    }
}