<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreCrudRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'    => 'required|unique:'.config('permission.table_names.users', 'users').',email',
            'name'     => 'required',
            'password' => 'required|confirmed|min:6',
            'iin'      => 'integer|nullable',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Емайл должен быть заполнен',
            'name.required' => 'Заполните Название',
            'password.required' => 'Заполните поле пароля',
            'password.confirmed' => 'Пароли не совпадают',
            'unique' => 'Такой пользователь уже существует',
            'min' => 'Пароль должен быть больше 6 символов',
            'iin.numeric' => 'Поле должно быть заполнено цифрами',
            'iin.integer' => 'Поле должно быть заполнено цифрами',
        ];
    }
}
