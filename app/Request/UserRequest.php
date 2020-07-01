<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class UserRequest extends FormRequest
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
            case '/user/register':
                $rules['username'] = 'required|max:10';
                $rules['password'] = 'required|min:6|max:10|alpha_num';
                $rules['avatar'] = 'max:30';
                break;
            case '/user/login':
                $rules['chat_no'] = 'required|exists:users';
                $rules['password'] = 'required';
                break;
        }
        return $rules;
    }

    public function messages(): array
    {
        return [
            'username.required' => '请填写昵称',
            'username.max' => '昵称最长10位',
            'password.required' => '请填写密码',
            'password.min' => '密码最少6位',
        ];
    }
}
