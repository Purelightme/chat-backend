<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class PostRequest extends FormRequest
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
     */
    public function rules(): array
    {
        $rules = [];
        switch ($this->getPathInfo()){
            case '/post/index':
                break;
            case '/post/store':
                $rules['content'] = 'required|max:200';
                break;
            case '/post/update':
                $rules['id'] = 'required|exists:posts';
                $rules['content'] = 'required|max:200';
                break;
            case '/post/destroy':
                $rules['id'] = 'required|exists:posts';
                break;
        }
        return $rules;
    }
}
