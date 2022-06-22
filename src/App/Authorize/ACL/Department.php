<?php
declare(strict_types=1);

namespace App\Authorize\ACL;

class Department
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getDepartmentName(): string
    {
        return $this->name;
    }
}