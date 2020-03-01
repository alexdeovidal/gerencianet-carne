<?php


namespace Source\Models;


use CoffeeCode\DataLayer\DataLayer;

class Tickets extends DataLayer
{
public function __construct()
{
    parent::__construct(DB_TICKETS, ["id_carnets", "charge_id", "parcel", "status", "value", "expire_at", "url"], "id");
}
}