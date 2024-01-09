<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;

class InscriptionsExport implements FromArray
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array() : array
    {
        $data = DB::table('users')
            ->join('accounts', 'users.id', '=', 'accounts.user_id')
            ->join('creative_datas', 'accounts.id', '=', 'creative_datas.account_id')
            ->join('creative_data_announcement', 'creative_datas.id', '=', 'creative_data_announcement.creative_data_id')
            ->join('announcements', 'creative_data_announcement.announcement_id', '=', 'announcements.id')
            ->get([
                'creative_datas.id',
                'users.email',
                'creative_datas.first_name',
                'creative_datas.last_name',
                'creative_data_announcement.announcement_id',
                'announcements.title',
                'creative_data_announcement.created_at',
            ])->toArray();
        array_unshift($data, $this->headings());
        return $data;
    }

    public function headings()
    {
        return [
            "ID Usuario",
            "Mail",
            "Nombre/s",
            "Apellido/s",
            "ID Convocatoria",
            "Nombre Convocatoria",
            "Fecha hora de inscripción"
        ];
    }
}
