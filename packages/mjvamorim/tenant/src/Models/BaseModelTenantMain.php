<?php


namespace Amorim\Tenant\Models;

use Amorim\Tenant\Models\BaseModel;
use Amorim\Tenant\TenantConnector;

class BaseModelTenantMain extends BaseModel
{

    use TenantConnector;
       
    protected $connection = 'main';
    /**
     * @return $this
     */
    public function connect() {
        $this->reconnect($this);
        return $this;
    }


}