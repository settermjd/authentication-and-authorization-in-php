<?php
declare(strict_types=1);

use App\Authorize\RBAC\Department;
use App\Authorize\RBAC\DynamicAssertions\AssertUserDepartmentMatches;
use App\Authorize\RBAC\User;
use Laminas\Permissions\Rbac\Rbac;
use Laminas\Permissions\Rbac\Role;

require_once __DIR__ . "/../../vendor/autoload.php";

$itRole = new Role('IT');
$securityRole = new Role('Security');
$helpdeskOperatorRole = new Role('Helpdesk.Operator');
$helpdeskManagerRole = new Role('Helpdesk.Manager');

$helpdeskManagerRole->addChild($helpdeskOperatorRole);
$itRole->addChild($securityRole);
$itRole->addChild($helpdeskManagerRole);

$helpdeskOperatorRole->addPermission('users.search');
$helpdeskOperatorRole->addPermission('users.password.change');
$helpdeskOperatorRole->addPermission('users.suspend');
$helpdeskManagerRole->addPermission('users.add');
$helpdeskManagerRole->addPermission('users.update');
$helpdeskManagerRole->addPermission('users.delete');

$rbac = new Rbac();
$rbac->addRole($itRole);
$rbac->addRole($securityRole);
$rbac->addRole($helpdeskManagerRole);
$rbac->addRole($helpdeskOperatorRole);

$jane = new User('Jane', $helpdeskManagerRole);
$michael = new User('Michael', $helpdeskOperatorRole);

if ($rbac->isGranted($jane->getRole(), 'users.add')) {
    // ...
}

$financeDepartment = new Department(1, 'Finance');
$itDepartment = new Department(2, 'IT');

$jane = new User('Jane', $helpdeskManagerRole, $financeDepartment);
$michael = new User('Michael', $helpdeskOperatorRole, $itDepartment);

$assertion = new AssertUserDepartmentMatches($financeDepartment, $jane);

if ($rbac->isGranted($jane->getRole(), 'users.add', $assertion)) {
    // ...
}