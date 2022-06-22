<?php
declare(strict_types=1);

namespace App\Authorize\RBAC;

class Department
{
    private int $departmentId;
    private string $name;

    public function __construct(int $departmentId, string $name)
    {
        $this->departmentId = $departmentId;
        $this->name = $name;
    }

    public function getDepartmentId(): int
    {
        return $this->departmentId;
    }
}