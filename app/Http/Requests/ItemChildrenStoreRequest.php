<?php
declare(strict_types = 1);

namespace App\Http\Requests;

class ItemChildrenStoreRequest extends ApiRequest
{
    public function rules()
    {
        return [
            '*.field' => 'required',
        ];
    }
}
