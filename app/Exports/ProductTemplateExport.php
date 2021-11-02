<?php

namespace App\Exports;

use App\Models\Size;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class ProductTemplateExport implements FromCollection, WithTitle, WithHeadings, WithEvents
{
    /**
     * @return string
     */
    public function title(): string
    {
        return 'ProductTemplate';
    }

    public function headings(): array
    {
        $sizes = Size::all()->pluck('name')->toArray();
        return array_merge([
            'SKU',
            'Name',
            'Article Code',
            'Total In Stock',
        ], $sizes);
    }

    public function collection()
    {
        return collect([]);
    }

    public function registerEvents(): array
    {
        //$event = $this->getEvent();
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                /**
                 * Görev
                 */
                // $items = Size::all()->pluck('name')->implode(',');
                // $sheet->setCellValue('G2', "Seçim Yapınız");
                // $objValidation = $sheet->getCell('G2')->getDataValidation();
                // $objValidation->setType(DataValidation::TYPE_LIST);
                // $objValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                // $objValidation->setAllowBlank(true);
                // $objValidation->setShowDropDown(true);
                // $objValidation->setFormula1('"' . $items . '"');

                /**
                 * Ünvan
                 */
                // $items = Title::where('company_id', $this->companyId)->pluck('name')->implode(',');
                // $sheet->setCellValue('H2', "Seçim Yapınız");
                // $objValidation = $sheet->getCell('H2')->getDataValidation();
                // $objValidation->setType(DataValidation::TYPE_LIST);
                // $objValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                // $objValidation->setAllowBlank(true);
                // $objValidation->setShowDropDown(true);
                // $objValidation->setFormula1('"' . $items . '"');
            }
        ];
    }
}
