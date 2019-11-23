<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateCrudRequest extends FormRequest
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
        $userModel = config('backpack.permissionmanager.models.user');
        $user = new $userModel();

        if (!$user->find($this->get('id'))) {
            abort(400, 'Could not find that entry in the database.');
        }

        return [
            'email'    => 'required|unique:'.config('permission.table_names.users', 'users').',email,'.$this->get('id'),
            'name'     => 'required',
            'password' => 'confirmed',
            'iin'      => 'numeric',

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
        ];
    }
}
