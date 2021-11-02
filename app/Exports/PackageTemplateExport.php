<?php

namespace App\Exports;

use App\Models\Size;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class PackageTemplateExport implements FromCollection, WithTitle, WithHeadings
{
    /**
     * @return string
     */
    public function title(): string
    {
        return 'PackageTemplate';
    }

    public function headings(): array
    {
        $sizes = Size::all()->pluck('name')->toArray();
        return array_merge([
            'Name',
            'Total Quantity',
        ], $sizes);
    }

    public function collection()
    {
        return collect([]);
    }
}
