<?php

namespace App\Exports;

use App\Models\DataOutput;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DataExport implements FromArray, WithHeadings, ShouldAutoSize
{
    protected $data;

    function __construct(array $data) {
           $this->data = $data;
    }

    public function headings(): array
    {
        return [
            '#',
            __('template.name'),
            __('template.brand'),
            __('template.model'),
            __('template.serial_no'),
            __('template.ern_code'),
            __('template.record_no_outgoing'),
            __('template.record_no_incoming'),
            __('template.hospital'),
            __('template.entry_date'),
            __('template.release_date'),
            __('template.transactions'),
            __('template.personnel_name'),
            __('template.transaction_date'),
            __('template.department'),
            __('template.officer_name'),
            __('template.officer_contact'),
            __('template.accessory'),
            __('template.verifier_name'),
            __('template.verify_date'),
            __('template.bill_no'),
            __('template.tag_date'),
            __('template.note'),
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        return $this->data;
    }
}
