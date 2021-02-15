<?php

namespace App\Exports;

use App\FileLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FileLogExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    public function __construct($uuid)
    {
        $this->uuid=$uuid;
    }

    public function headings(): array
    {
        return ['Row Number','Delivery Note Number','Beat Name','Fail Reason'];
    }
    public function collection()
    {
        return FileLog::where('uuid',$this->uuid)->select('row_number','delivery_note_number','beat_name','fail_reason')->get();
    }
}
