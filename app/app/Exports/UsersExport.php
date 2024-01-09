<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersExport implements FromArray, WithHeadingRow
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array() : array
    {
        $data = DB::table('users')
            ->join('accounts', 'users.id', '=', 'accounts.user_id')
            ->join('creative_datas', 'accounts.id', '=', 'creative_datas.account_id')
            ->leftJoin('log_entries', 'users.id', '=', 'log_entries.user_id')
            ->leftJoin('study_levels', 'creative_datas.study_level_id', '=', 'study_levels.id')
            ->leftJoin('careers as primary_career', 'creative_datas.career_id', '=', 'primary_career.id')
            ->leftJoin('careers as secondary_career', 'creative_datas.secondary_career_id', '=', 'secondary_career.id')
            ->get([
                'creative_datas.id',
                'users.email',
                'creative_datas.first_name',
                'creative_datas.last_name',
                DB::raw('IF(creative_datas.gender = 0,"Masculino",IF(creative_datas.gender = 1, "Femenino", "Prefiere no decirlo"))'),
                'creative_datas.birth_date',
                'creative_datas.nationality',
                'creative_datas.country',
                'study_levels.name as study_level_name',
                'primary_career.name as primary_career_name',
                'secondary_career.name as secondary_career_name',
                DB::raw('IF(ISNULL(users.email_verified_at),"NO","SÍ")'),
                DB::raw('IF(users.active = 0,"Inactivo","Activo")'),
                'users.created_at',
                'log_entries.updated_at',
                'creative_datas.description',
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
            "Género",
            "Fecha de Nacimiento",
            "Nacionalidad",
            "País de Residencia",
            "Nivel de estudios",
            "Estudios primarios",
            "Estudios secundarios",
            "¿Mail validado? (Si/No)",
            "Estado",
            "Fecha creación",
            "Última conexión",
            "Texto introductorio de perfil",
            "Fecha/hora última conexión",
        ];
    }
}
