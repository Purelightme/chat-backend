<?php

declare(strict_types=1);

namespace App\Request;

use App\Model\UserFriendApply;
use Hyperf\Validation\Request\FormRequest;

class UserFriendApplyRequest extends FormRequest
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
            case '/user_friend_apply/store':
                $rules['chat_no'] = 'required|exists:users';
                break;
            case '/user_friend_apply/handle':
                $rules['id'] = 'required|exists:user_friend_applies';
                $rules['status'] = 'required|in:'.UserFriendApply::STATUS_REFUSE.','.UserFriendApply::STATUS_PASS;
                break;
        }
        return $rules;
    }
}
