<?php

namespace App\Exports;

use App\Models\Size;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ShopTemplateExport implements FromCollection, WithTitle, WithHeadings
{
    /**
     * @return string
     */
    public function title(): string
    {
        return 'ShopTemplate';
    }

    public function headings(): array
    {
        return [
            'Name',
        ];
    }

    public function collection()
    {
        return collect([]);
    }
}
