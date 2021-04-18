<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnnouncementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:65',
            'body' => 'required|string|max:600',
            'price' => 'required|numeric',
        ];
        
    }

    public function messages()
{
    return [
        'title.required' => 'Il titolo è obbligatorio',
        'body.required' => 'La descrizione è obbligatorio',
        'price.required' => 'Il prezzo è obbligatorio',
    ];
}    
}
