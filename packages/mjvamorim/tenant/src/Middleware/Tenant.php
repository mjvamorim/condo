<?php

namespace Amorim\Tenant\Middleware;

use Amorim\Tenant\Models\Empresa;
use Amorim\Tenant\TenantConnector;

use Amorim\Tenant\TenantConfigDB;
use Illuminate\Http\Request;
use Closure;

class Tenant {

    use TenantConnector;

    protected $empresa;

    public function __construct(Empresa $empresa) {
        $this->empresa = $empresa;
    }

    public function selectTenant(Request $request, Empresa $empresa) {
        TenantConfigDB::createDatabase($empresa);
        $this->reconnect($this->empresa->findOrFail($empresa->id)); 
        $request->session()->put('tenant', $empresa);
        TenantConfigDB::createTenantTables();
    }
    public function createEmpresaAuthUser() { 
        $user = auth()->user();
        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'mobile' => $user->mobile,
        ];
        $empresa = TenantConfigDB::createEmpresa($data);
        $user->empresa_id = $empresa->id;
        $user->save();
    }

    public function handle(Request $request, Closure $next) {
        if (auth()->check()) {
            if (auth()->user()->empresa == null) {
                $this->createEmpresaAuthUser();
            }
            $this->selectTenant($request, auth()->user()->empresa);
        }

        if (($request->session()->get('tenant')) === null)
            return redirect()->route('home')->withErrors(['error' => __('Please select a customer/tenant before making this request.')]);
        // Get the empresa object with the id stored in session
        $empresa = $this->empresa->find($request->session()->get('tenant')->id);
      

        // Connect and place the $empresa object in the view
        $this->reconnect($empresa);
        $request->session()->put('empresa', $empresa);
        $request->session()->put('tenant', $empresa);
          
        return $next($request);
    }
}
