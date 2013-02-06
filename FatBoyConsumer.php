<?php
require_once('vendor/autoload.php');
require_once('FatBoy.php');

$app = new \Slim\Slim();
$fatBoy = new \FatBoy\FatBoy($entityManager, $app->request());
$user = $fatBoy->Wedge('user');

$user->setPermission(\FatBoy\Permission::none()
    ->add(\FatBoy\PERMISSION_WRITE)
    ->subtract(\FatBoy\PERMISSION_DELETE)); //Set all permissions for all members
$user->setPermission(\FatBoy\PERMISSION_READ, 'id'); //Limit permissions for id member to read only
$user->setPermission(\FatBoy\PERMISSION_NONE, 'owner'); //Turn off all permissions for owner member

\FatBoy\FatBoy::CRUDSlim($app, $user);
$app->run();
