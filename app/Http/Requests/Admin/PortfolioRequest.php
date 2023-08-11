<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PortfolioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => "required|max:191|unique:portfolios,title,{$this->id},id,deleted_at,NULL",
            'subtitle' => 'required|max:191',
            'cover' => 'required_if:cover,null|image|mimes:jpg,png,jpeg,gif,svg,webp|max:4096|dimensions:max_width=4000,max_height=4000',
            'content' => 'required|max:4294967295',
            'status' => 'required|in:post,draft,trash',
        ];
    }
}
