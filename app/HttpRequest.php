<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HttpRequest extends Model
{
    protected $fillable = [
        'request_url',
        'request_content',
        'request_method',
        'response'
    ];

    public function getPrettyRequestContentAttribute()
    {
        return json_encode(json_decode($this->request_content), JSON_PRETTY_PRINT);
    }

    public static function createFrom($request, $response)
    {
        return self::create([
            'request_url' => $request->fullUrl(),
            'request_content' => $request->getContent(),
            'request_method' => $request->method(),

            'response' => $response->getContent(),
        ]);
    }
}
