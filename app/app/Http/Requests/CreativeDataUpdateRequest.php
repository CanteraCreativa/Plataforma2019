<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\UserGender;
use App\Enums\Countries;

class CreativeDataUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();
        $account = \App\Models\CreativeData::find($this->route('creative'))->account;
        return $account
            && $user->hasRole('creative')
            && $account->user->id === $user->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name'          => 'required|string|nullable',
            'last_name'           => 'required|string|nullable',
            'gender'              => 'required|required|enum_key:' . UserGender::class,
            'birth_date'          => 'required|required|date',
            'phone'               => 'sometimes|nullable|phone:AR',
            'address'             => 'sometimes|nullable|string',
            'studies'             => 'sometimes|string|nullable',
            'studies_where'       => 'sometimes|string|nullable',
            'country'             => 'required|string|nullable|enum_value:' . Countries::class,
            'nationality'         => 'sometimes|string|nullable|enum_value:' . Countries::class,
            'mercadopago_account' => 'sometimes|string|nullable',
            'description'         => 'sometimes|string|nullable|max:500',
            'skills'              => 'sometimes|array',
            'skills.*'            => 'sometimes|array',
            'skills.*.id'         => 'sometimes|exists:skills,id',
            'skills.*.level'      => 'sometimes|integer|min:0|max:10',
            'interests'           => 'sometimes|array',
            'interests.*'         => 'sometimes|exists:interests,id',
            'links'               => 'sometimes|array',
            'links.*'             => 'string|url',
            'career_id'           => 'sometimes|nullable|exists:careers,id',
            'study_level_id'      => 'sometimes|nullable|exists:study_levels,id',
        ];
    }

    public function attributes()
    {
        return [
            'first_name'          => 'Nombre',
            'last_name'           => 'Apellido',
            'gender'              => 'Género',
            'age'                 => 'Edad',
            'birth_date'          => 'Fecha de nacimiento',
            'phone'               => 'Teléfono',
            'address'             => 'Dirección',
            'studies'             => 'Estudios',
            'studies_where'       => 'Centro de estudios',
            'country'             => 'País',
            'nationality'         => 'Nacionalidad',
            'mercadopago_account' => 'Cuenta MercadoPago',
            'description'         => 'Descripción',
            'skills'              => 'Habilidades',
            'skills.*'            => 'Cada Habilidad',
            'skills.*.id'         => 'Habilidad > ID',
            'skills.*.level'      => 'Habilidad > Nivel',
            'interests'           => 'Intereses',
            'interests.*'         => 'Cada Interés',
            'links'               => 'Links',
            'links.*'             => 'Link',
        ];
    }
}
