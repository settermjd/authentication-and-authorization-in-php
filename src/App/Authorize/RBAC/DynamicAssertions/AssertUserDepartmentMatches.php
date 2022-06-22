<?php
declare(strict_types=1);

namespace App\Authorize\RBAC\DynamicAssertions;

use App\Authorize\RBAC\Department;
use App\Authorize\RBAC\User;
use Laminas\Permissions\Rbac\AssertionInterface;
use Laminas\Permissions\Rbac\Rbac;
use Laminas\Permissions\Rbac\RoleInterface;

class AssertUserDepartmentMatches implements AssertionInterface
{
    private Department $department;
    private User $user;

    public function __construct(Department $department, User $user)
    {
        $this->department = $department;
        $this->user = $user;
    }

    public function assert(Rbac $rbac, RoleInterface $role, string $permission): bool
    {
        return $this->user->getDepartment()->getDepartmentId() === $this->department->getDepartmentId();
    }
}