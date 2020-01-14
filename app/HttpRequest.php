<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HttpRequest extends Model
{
    public function getPrettyRequestContentAttribute()
    {
        return json_encode(json_decode($this->request_content), JSON_PRETTY_PRINT);
    }
}
