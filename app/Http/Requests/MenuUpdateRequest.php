<?php
declare(strict_types = 1);

namespace App\Http\Requests;

class MenuUpdateRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'field' => 'required',
        ];
    }
}
