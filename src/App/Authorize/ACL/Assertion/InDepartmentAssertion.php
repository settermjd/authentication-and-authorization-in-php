<?php
declare(strict_types=1);

namespace App\Authorize\ACL\Assertion;

use App\Authorize\ACL\Department;
use Laminas\Permissions\Acl\Acl;
use Laminas\Permissions\Acl\Resource\ResourceInterface;
use Laminas\Permissions\Acl\Role\RoleInterface;

class InDepartmentAssertion
{
    private Department $department;
    private string $requiredDepartment;

    public function __construct(Department $department, string $requiredDepartment)
    {
        $this->department = $department;
        $this->requiredDepartment = $requiredDepartment;
    }

    public function __invoke(
        Acl $acl,
        ?RoleInterface $role = null,
        ?ResourceInterface $resource = null,
        ?string $privilege = null
    ): bool
    {
        return $this->department->getDepartmentName() === $this->requiredDepartment;
    }
}