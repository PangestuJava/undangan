<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait HasBasicCRUD
{
    use HasHttpResponse;

    public function getAll()
    {
        $result = DB::table($this->table)->orderByDesc('created_at')->get();

        $this->handleResourceNotExist($result);

        return $result;
    }

    public function findById(int $id)
    {
        $result = DB::table($this->table)->where('id', $id)->first();

        $this->handleResourceNotExist($result);

        return $result;
    }

    public function findByUuid(string $uuid)
    {
        $result = DB::table($this->table)->where('uuid', $uuid)->first();

        $this->handleResourceNotExist($result);

        return $result;
    }

    public function create(array $data)
    {
        return DB::table($this->table)->insertGetId($data);
    }

    public function createMultiple(array $dataArray)
    {
        return DB::table($this->table)->insert($dataArray);
    }

    public function updateById(int $id, array $data)
    {
        $this->findById($id);

        $updated = DB::table($this->table)->where('id', $id)->update($data);

        return $updated;
    }

    public function updateMultipleById(array $dataArray)
    {
        foreach ($dataArray as $data) {
            $this->findById($data['id']);

            DB::table($this->table)->where('id', $data['id'])->update($data);
        }
    }

    public function updateByUuid(string $uuid, array $data)
    {
        $this->findByUuid($uuid);

        $updated = DB::table($this->table)->where('uuid', $uuid)->update($data);

        return $updated;
    }

    public function updateMultipleByUuid(array $dataArray)
    {
        foreach ($dataArray as $data) {
            $this->findByUuid($data['uuid']);

            DB::table($this->table)->where('uuid', $data['uuid'])->update($data);
        }
    }

    public function destroyById(int $id)
    {
        $this->findById($id);

        $deleted = DB::table($this->table)->where('id', $id)->delete();

        return $deleted;
    }

    public function destroyMultipleById(array $ids)
    {
        foreach ($ids as $id) {
            $this->findById($id);

            DB::table($this->table)->where('id', $id)->delete();
        }
    }

    public function destroyByUuid(string $uuid)
    {
        $this->findByUuid($uuid);

        $deleted = DB::table($this->table)->where('uuid', $uuid)->delete();

        return $deleted;
    }

    public function destroyMultipleByUuid(array $uuids)
    {
        foreach ($uuids as $uuid) {
            $this->findByUuid($uuid);

            DB::table($this->table)->where('uuid', $uuid)->delete();
        }
    }
}
