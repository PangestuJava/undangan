<?php

namespace App\Services\Central\Admin;

use App\Traits\HasBasicCRUD;
use App\Traits\HasBasicSearch;
use App\Traits\HasHttpResponse;

/**
 * Class TenantService.
 */
class TenantService
{
    use HasHttpResponse, HasBasicCRUD, HasBasicSearch;

    protected $table;

    public function __construct()
    {
        $this->table = 'tenants';
    }

    public function createTenant() {}
}
