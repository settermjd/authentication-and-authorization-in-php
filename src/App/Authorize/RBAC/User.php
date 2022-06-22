<?php
declare(strict_types=1);

namespace App\Authorize\RBAC;

use Laminas\Permissions\Rbac\RoleInterface;

class User
{
    private string $firstName;
    private RoleInterface $role;
    private ?Department $department;

    public function __construct(string $firstName,
                                RoleInterface $role,
                                ?Department $department = null)
    {
        $this->firstName = $firstName;
        $this->department = $department;
        $this->role = $role;
    }

    public function getDepartment(): Department
    {
        return $this->department;
    }

    public function getRole(): RoleInterface
    {
        return $this->role;
    }
}