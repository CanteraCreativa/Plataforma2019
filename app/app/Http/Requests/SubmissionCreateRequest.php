<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmissionCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user() && $this->user()->hasRole('creative');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'                   => 'required|string|max:2000',
            'image_file'             => 'required|file|mimes:png,jpg,jpeg|max:10240',
            'description'            => 'required|string|max:2000',
            /*'skills'                 => 'sometimes|array',
            'skills.*'               => 'required|exists:skills,id',
            'legal_external'         => 'sometimes|boolean',
            'legal_external_details' => 'sometimes|string|max:320',
            'legal_author'           => 'sometimes|boolean',
            'legal_human_figures'    => 'sometimes|boolean',
            'answer_question_1'      => 'required|string',
            'answer_question_2'      => 'required|string',
            'answer_question_3'      => 'required|string',*/
        ];
    }
}
