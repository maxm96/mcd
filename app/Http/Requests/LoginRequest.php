<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Nette\Schema\ValidationException;

class LoginRequest extends FormRequest
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
            'email' => 'required|string|email',
            'name' => 'required|string',
            'password' => 'required|string',
        ];
    }

    public function authenticate()
    {
        if (!Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            throw new ValidationException('Auth failed');
        }
    }
}
