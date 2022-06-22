<?php
declare(strict_types=1);

use App\Authorize\ACL\Assertion\InDepartmentAssertion;
use App\Authorize\ACL\Department;
use Laminas\Permissions\Acl\Acl;
use Laminas\Permissions\Acl\Assertion\CallbackAssertion;
use Laminas\Permissions\Acl\Resource\GenericResource;
use Laminas\Permissions\Acl\Role\GenericRole;

require_once __DIR__ . "/../../vendor/autoload.php";

$acl = new Acl();

$guestRole = new GenericRole('Guest');
$customerRole = new GenericRole('Customer');
$helpdeskOperator = new GenericRole('Helpdesk.Operator');
$helpdeskManager = new GenericRole('Helpdesk.Manager');
$adminRole = new GenericRole('Admin');

$acl->addRole($guestRole)
    ->addRole($customerRole, $guestRole)
    ->addRole($helpdeskOperatorRole, $customerRole)
    ->addRole($helpdeskManagerRole, [$helpdeskOperatorRole])
    ->addRole($adminRole);

$helpdeskOperatorBeginner = new GenericRole('Helpdesk.Operator.Beginner');
$helpdeskOperator = new GenericRole('Helpdesk.Operator');
$helpdeskManager = new GenericRole('Helpdesk.Manager');

$acl->addRole($guestRole)
    ->addRole($customerRole, $guestRole)
    ->addRole($helpdeskOperator, $customerRole)
    ->addRole($helpdeskOperatorBeginner)
    ->addRole(
        $helpdeskManager,
        [
            $helpdeskOperator,
            $helpdeskOperatorBeginner
        ]
    )
    ->addRole($adminRole);

$acl->addResource(new GenericResource('dashboard'));

$acl->allow($guestRole, null, 'view');
$acl->allow($customerRole, null, ['login', 'logout', 'profile']);
$acl->allow(
    $helpdeskOperator,
    'dashboard',
    ['user.suspend', 'user.password.change', 'user.search']
);
$acl->allow($helpdeskManager, 'dashboard', ['user.add', 'user.update', 'user.delete']);
$acl->allow($adminRole);

$acl->deny($guestRole, 'dashboard', 'login');

if ($acl->isAllowed($helpdeskOperator, 'dashboard', 'user.suspend')) {
    // ...
}

$department = new Department('marketing');
$assertion = new InDepartmentAssertion($department, 'finance');

$acl->allow(
    $helpdeskOperator,
    'dashboard',
    ['user.suspend', 'user.password.change', 'user.search'],
    new CallbackAssertion($assertion)
);