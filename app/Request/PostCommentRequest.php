<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class PostCommentRequest extends FormRequest
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
            case '/post_comment/index':
                break;
            case '/post_comment/store':
                $rules['content'] = 'required|max:100';
                $rules['response_user_id'] = 'exists:users,id';
                break;
        }
        return $rules;
    }
}
