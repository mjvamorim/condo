<?php

namespace Amorim\Tenant;


use Amorim\Tenant\Models\Empresa;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


trait TenantConnector {
   

    public function reconnect(Empresa $empresa) {     
        // Erase the tenant connection, thus making Laravel get the default values all over again.
        DB::purge('tenant');
        
        // Make sure to use the database name we want to establish a connection.
        $host = in_array($empresa->db_host, ['127.0.0.1', 'localhost'], true)
            ? Config::get('database.connections.main.host')
            : $empresa->db_host;

        Config::set('database.connections.tenant.host', $host);
        Config::set('database.connections.tenant.database', $empresa->db_database);
        Config::set('database.connections.tenant.username', $empresa->db_username);
        Config::set('database.connections.tenant.password', $empresa->db_password);
        
        // Rearrange the connection data
        DB::reconnect('tenant');
        // Ping the database. This will throw an exception in case the database does not exists or the connection fails
        Schema::connection('tenant')->getConnection()->reconnect();
     }
     
  }