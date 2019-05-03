<?php

namespace App\Exports;

use app\Models\Hamahang\CalendarEvents\User_Event;
use Maatwebsite\Excel\Concerns\FromCollection;

class invokeExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User_Event::all();
    }
}
