<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class ExportReport implements FromCollection, WithHeadings
{
    protected $data;
    protected $heading;


    public function __construct($data,$heading)
    {
        $this->data = $data;
        $this->heading = $heading;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $dataArray = $this->data->toArray();

        $transformedData = array_map(function ($row) {
            return array_map(function ($value) {
                return $value === 0 ? '0' : $value;
            }, $row);
        }, $dataArray);

        return new Collection($transformedData);
    }


    public function headings(): array
    {
        return  $this->heading;
    }
}
