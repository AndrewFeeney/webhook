<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class HandledRequest extends Model
{
    protected $guarded = [];

    public static function createFromRequest(Request $request, Webhook $webhook)
    {
        return self::create([
            'method'     => $request->method(),
            'webhook_id' => $webhook->id,
            'query'      => json_encode($request->query()),
            'parameters' => json_encode($request->request->all()),
            'content'    => $request->getContent(),
            'json'       => $request->getContent() ? json_encode(json_decode($request->getContent()), JSON_PRETTY_PRINT) : null,
            'headers'    => json_encode($request->headers->all()),
        ]);
    }

    public function getHeadersAttribute()
    {
        return collect(json_decode($this->attributes['headers']));
    }
}
