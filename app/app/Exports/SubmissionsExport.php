<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SubmissionsExport implements FromArray, WithHeadingRow
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function array() : array
    {
        $data = DB::table('submissions')
            ->orderBy('id', 'asc')
            ->join('creative_data_announcement', 'submissions.inscription_id', '=', 'creative_data_announcement.id')
            ->join('announcements', 'creative_data_announcement.announcement_id', '=', 'announcements.id')
            ->get([
                'submissions.id',
                'creative_data_announcement.announcement_id',
                'announcements.company',
                'announcements.title',
                'submissions.name',
                'submissions.description',
                DB::raw('CONCAT("'.url('view_submission_image?id=').'",to_base64(submissions.id))'),
                'creative_data_announcement.creative_data_id',
                'creative_data_announcement.created_at',
                DB::raw('IF(submissions.state = 0, "Sin responder", IF(submissions.state = 1, "Aceptada", "Rechazada"))'),
                'submissions.review_observation',
                'submissions.created_at',
                'submissions.updated_at',
            ])
            ->toArray();
        array_unshift($data, $this->headings());
        return $data;
    }

    public function headings()
    {
        return [
            "ID Idea",
            "ID Convocatoria",
            "Empresa (Marca)",
            "Título Convocatoria",
            "Nombre de la idea",
            "Descripción de la idea",
            "Link a imagen de soporte de la idea",
            "ID User",
            "Fecha/hora OK Acuerdo convocatoria",
            "Estado de la idea",
            "Comentario del estado",
            "Fecha/hora creación idea",
            "Fecha/hora último cambio de estado",
        ];
    }
}
