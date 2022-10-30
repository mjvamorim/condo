<?php


namespace Amorim\Tenant;

use Illuminate\Support\Facades\Schema;


trait TenantModel {
   


    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public static function getColumns() {
        return Schema::getColumnListing(self::getTableName()); 

    }

    public static function getFillableFields() {
        return with(new static)->getFillable();
    }

    public static function getShowableFields() {
        return with(new static)->showable;
    }

    public static function getRules() {
        return with(new static)->rules;
    }

    public static function getActions() {
        return with(new static)->actions;
    }

    public static function blank() {
        $blank=[];
        foreach(self::getShowableFields() as $item) {
            $blank+=[$item['name']=>''];
        }
        return $blank;
    }
     
}