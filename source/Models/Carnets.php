<?php


namespace Source\Models;


use CoffeeCode\DataLayer\DataLayer;

class Carnets extends DataLayer
{
public function __construct()
{
    parent::__construct(DB_CARNETS,["id_students", "carnet_id", "link", "status"], "id");
}
}