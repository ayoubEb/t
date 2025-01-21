<?php

namespace App\Exports;

use App\Models\Produit;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
class ProduitsExample implements FromArray , WithHeadings , WithStyles , ShouldAutoSize
{
 
    
    protected $data;
      public function __construct(array $data)
      {
          $this->data = $data;
      }
      /**
      * @return \Illuminate\Support\Collection
      */
      public function array(): array
      {
          return $this->data;
      }
      public function headings(): array
      {
          return [
              Str::upper('nom'),
              Str::upper('Description'),
              Str::upper('Prix'),
              Str::upper('Quantite'),
          ];
      }
    
      public function styles(Worksheet $sheet)
      {
        // Alternatively, set default row height
        $sheet->getDefaultRowDimension()->setRowHeight(25);// Header row
        $sheet->getStyle('A1:K1')->applyFromArray([
          'font' => [
              'bold' => true,
              'size' => 10,
          ],
    
          'fill' => [
              'fillType' => Fill::FILL_SOLID,
              'startColor' => [
                  'argb' => 'FFDDDDDD', // Light gray
              ],
          ],
      ]);
        $sheet->getStyle('A:K')->applyFromArray([
          'alignment' => [
            'vertical' => Alignment::VERTICAL_CENTER,
        ],
      ]);
      return [];
      }
}
