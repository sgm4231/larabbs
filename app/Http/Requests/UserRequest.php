<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required|between:3,25|regex:/^[A-Za-z0-9\-\_]+$/|unique:users,name,' . Auth::id(),
            'email' => 'required|email',
            'introduction' => 'max:80',
        ];

        //name.required —— 验证的字段必须存在于输入数据中，而不是空。详见文档
        //name.between —— 验证的字段的大小必须在给定的 min 和 max 之间。详见文档
        //name.regex —— 验证的字段必须与给定的正则表达式匹配。详见文档
        //name.unique —— 验证的字段在给定的数据库表中必须是唯一的。详见文档
        //email.required —— 同上
        //email.email —— 验证的字段必须符合 e-mail 地址格式。详见文档
        //introduction.max —— 验证中的字段必须小于或等于 value。详见文档
    }


    public function messages()
    {
        return [
            'name.unique' => '用户名已被占用，请重新填写',
            'name.regex' => '用户名只支持英文、数字、横杠和下划线。',
            'name.between' => '用户名必须介于 3 - 25 个字符之间。',
            'name.required' => '用户名不能为空。',
        ];
    }
}
