<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Spatie\Permission\Models\Permission;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithValidation;

class PermissionImport implements ToModel, SkipsOnError, WithValidation
{
    use Importable;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Permission([
            'name' => $row[0],
            'group_name' => $row[1],
        ]);
    }

    public function rules():array
    {
        return [
            'name' => 'string',
            'group_name' => 'string'
        ];
    }

    public function onError(\Throwable $e)
    {
        // Handle the exception how you'd like.
    }
}
