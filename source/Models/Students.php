<?php


namespace Source\Models;


use CoffeeCode\DataLayer\DataLayer;

class Students extends DataLayer
{
public function __construct()
{
    parent::__construct(DB_STUDENTS, [
        "parent_id",
        "route_id",
        "school_house_id",
        "blood_group",
        "vehroute_id",
        "hostel_room_id",
        "guardian_is",
        "guardian_occupation",
        "father_pic",
        "mother_pic",
        "guardian_pic",
        "height",
        "weight",
        "measurement_date",
        "dis_reason",
        "batch_id",
        "disable_at",
        "created_at"
    ], "id");
}
}