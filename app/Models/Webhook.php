<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Webhook extends Model
{
    public function url()
    {
        return url('webhook/'.$this->uri);
    }

    public function captureRequest(Request $request)
    {
        return HandledRequest::createFromRequest($request, $this);
    }
}
