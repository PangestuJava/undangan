<?php

namespace App\Http\Controllers\Central\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Central\Admin\TenantService;
use App\Http\Resources\Central\Index\TenantResource;
use App\Http\Requests\Central\Admin\Index\TenantRequest;
use App\Http\Requests\Central\Admin\Store\StoreTenantRequest;

class TenantController extends Controller
{
    protected $tenantService;

    /**
     * Create a new controller instance.
     *
     * @param TenantService $tenantService
     */
    public function __construct(TenantService $tenantService)
    {
        $this->tenantService = $tenantService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(TenantRequest $request)
    {
        $data = $request->validated();

        $tenants = $this->tenantService->search(10, $data['search'] ?? null, ['id']);

        return $this->tenantService->successPaginate(TenantResource::collection($tenants));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTenantRequest $request)
    {
        $data = $request->validated();

        $tenants = $this->tenantService->createTenant(10, $data['search'] ?? null, ['id']);

        return $this->tenantService->successPaginate(TenantResource::collection($tenants));
    }

    /**
     * Display the specified resource.
     */
    public function get(string $uuid)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $uuid)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {
        //
    }
}
