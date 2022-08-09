<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    //権限の設定は別途policyに書くのでここは一律true
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
            'name' => 'required|max:50',
            'detail' => 'max:500',
            'tags' => 'json|regex:/^(?!.*\s).+$/u|regex:/^(?!.*\/).*$/u',            
        ];
    }

    public function attributes()
    {
        return [
            'name' => '単語名',
            'detail' => '本文',
            'tags' => 'タグ',
        ];
    }

    public function passedValidation()
    {
        $this->tags = collect(json_decode($this->tags))
            ->slice(0, 5)
            ->map(function ($requestTag) {
                return $requestTag->text;
            });
    }    
}