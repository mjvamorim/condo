<?php

namespace Amorim\Tenant\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;
use Amorim\Tenant\TenantModel;


class BaseModel extends Model
{
    use TenantModel;
   
}
