<?php
namespace FatBoy;

const PERMISSION_NONE   = 0;  //No rights
const PERMISSION_CREATE = 1;  //Insert entity
const PERMISSION_SET    = 2;  //Set undefined/null members
const PERMISSION_UPDATE = 4;  //Set new member value
const PERMISSION_DELETE = 8;  //Delete entity
const PERMISSION_READ   = 16; //Read member
const PERMISSION_WRITE  = 15; //PERMISSION_CREATE | PERMISSION_SET | PERMISSION_UPDATE | PERMISSION_DELETE);
const PERMISSION_ALL    = 31; //PERMISSION_WRITE | PERMISSION_READ);

/**
 * Tooling around the PERMISSION_* constants.
 * Can by applied to entities or members.
 */
class Permission
{
    private $_permission;

    public function __construct($permission = PERMISSION_NONE)
    {
        $this->_permission = $permission;
    }

    public static function none()
    {
        return new Permission();
    }

    public static function all()
    {
        return new Permission(PERMISSION_ALL);
    }

    public function add($permission)
    {
        $this->_permission |= $permission;
        return $this;
    }

    public function subtract($permission)
    {
        $this->_permission = $this->_permission & !$permission;
        return $this;
    }

    public function get()
    {
        return $this->_permission;
    }
}

/**
 *
 */
class Entity
{
    public function create () {}
    public function report () {}
    public function update () {}
    public function delete () {}

    public function setPermission($permission, $member = null)
    {
    }

    public function getName()
    {
        return "tbd";
    }
}

/**
 *
 */
class FatBoy
{
    /**
     * @param $entityName
     * @return Entity
     */
    public function Wedge ($entityName) {
        return new Entity();
    }

    /**
     * @param $app \Slim\Slim
     * @param $entity Entity
     */
    public static function CRUDSlim($app, $entity)
    {
        $name = $entity->getName();
        $app->post('/' . $name, array($entity,'create'));
        $app->put('/' . $name . '/:id', array($entity,'update'));
        $app->delete('/' . $name . '/:id', array($entity,'delete'));
        $app->get('/' . $name . '/:id', array($entity,'report')); //Get and hydrate children
        $app->get('/' . $name, array($entity,'report')); //Get with filters from request variables
    }
}

