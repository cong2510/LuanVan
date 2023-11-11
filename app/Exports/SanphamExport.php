<?php

namespace App\Exports;

use App\Models\Sanpham;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SanphamExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Sanpham::select('name','mota','soluong','gia')->get();
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array {
        return [
            // 'SL',
            // 'Brand_id',
            // 'Discount_id',
            // 'Name',
            // 'Mo ta',
            // 'Gia',
            // 'So luong',
            // 'Tinh trang',

            'Name',
            'Mo ta',
            'So luong',
            'Gia',


        ];
    }

}
