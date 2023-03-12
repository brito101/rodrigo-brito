<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CertificateRequest extends FormRequest
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
            'title' => 'required|min:1|max:191',
            'status' => 'required|in:post,draft,trash',
            'cover' => 'required_if:cover,null|image|mimes:jpg,png,jpeg,gif,svg,webp|max:4096|dimensions:max_width=4000,max_height=4000',
        ];
    }
}
