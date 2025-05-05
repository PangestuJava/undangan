<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

trait HasBasicSearch
{
    public function search(int $perPage = 10, ?string $query = null, array $searchableColumns = []): LengthAwarePaginator
    {
        $queryBuilder = DB::table($this->table);

        if (!empty($query) && !empty($searchableColumns)) {
            $queryBuilder->where(function ($q) use ($query, $searchableColumns) {
                foreach ($searchableColumns as $column) {
                    $q->orWhere($column, 'like', '%' . $query . '%');
                }
            });
        }

        // Clone untuk hitung total sebelum paginate
        $total = (clone $queryBuilder)->count();

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $results = $queryBuilder
            ->orderByDesc('id')
            ->forPage($currentPage, $perPage)
            ->get()
            ->map(fn($item) => (array) $item); // <- Ini penting!

        return new LengthAwarePaginator($results, $total, $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);
    }
}
