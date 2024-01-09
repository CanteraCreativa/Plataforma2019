<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnnouncementCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user() && $this->user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'                 => 'required|string',
            'company'               => 'required|string',
            'total_prize'           => 'required|integer|min:0',
            'start_date'            => 'required|date|after_or_equal:today',
            'end_date'              => 'required|date|after_or_equal:start_date',
            'results_date'          => 'required|date|after_or_equal:end_date',
            'short_description'     => 'required',
            'brief'                 => 'sometimes|file|mimes:pdf',
            'context'               => 'present',
            'challenge'             => 'present',
            //'tips'                  => 'present',
            //'first_prize'           => 'required|integer|min:0',
            //'second_prize'          => 'required|integer|min:0',
            //'third_prize'           => 'required|integer|min:0',
            //'format'                => 'present',
            //'criteria'              => 'present',
            'alignments'            => 'present',
            /* TODO: add extensions validation */
            'rules_file'            => 'required|file|mimes:pdf',
            'rules_summary'         => 'sometimes|nullable|string',
            'image_thumbnail'       => 'required|file|mimes:png,jpg,jpeg,gif',
            //'image_banner'          => 'required|file|mimes:png,jpg,jpeg,gif',
            'skills'                => 'sometimes|array',
            'skills.*'              => 'required|exists:skills,id',
            'interests'             => 'sometimes|array',
            'interests.*'           => 'required|exists:interests,id',
            'guidelines'            => 'sometimes|array',
            'guidelines.*'          => 'required|exists:guidelines,id',
            'winners'               => 'nullable|string'
        ];
    }

    public function attributes()
    {
        return [
            'title'                 => 'Título',
            'company'               => 'Empresa',
            'total_prize'           => 'Premio total',
            'start_date'            => 'Fecha inicio',
            'end_date'              => 'Fecha cierre',
            'results_date'          => 'Fecha resultados',
            'short_description'     => 'Descripción corta',
            'context'               => 'Contexto',
            'challenge'             => 'Desafío creativo',
            'tips'                  => 'Tips',
            'first_prize'           => '1er premio',
            'second_prize'          => '2do premio',
            'third_prize'           => '3er premio',
            'format'                => 'Formato',
            'criteria'              => 'Criterios de elección',
            'alignments'            => 'Lineamientos',
            'rules_file'            => 'Archivo reglas',
            'rules_summary'         => 'Resumen del reglamento',
            'image_thumbnail'       => 'Imagen thumbnail',
            'image_banner'          => 'Imagen banner',
            'skills'                => 'Habilidades',
            'interests'             => 'Intereses',
            'guidelines'            => 'Tipos de consigna',
        ];
    }
}
