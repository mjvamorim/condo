<?php

namespace Amorim\Tenant\Models;

use Amorim\Tenant\Models\BaseModel;

class BaseModelTenant extends BaseModel
{
    protected $connection = 'tenant';

    public function __construct()
    {      
        $this->setConnection('tenant');
    }

}