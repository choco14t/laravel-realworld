<?php

namespace App\Extensions;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Contracts\Http\Parser;

final class CustomAuthHeaders implements Parser
{
    /** @var string */
    private $header = 'authorization';

    /** @var string */
    private $prefix = 'token';

    /**
     * @inheritDoc
     */
    public function parse(Request $request)
    {
        $header = $request->headers->get($this->header);

        if ($header && preg_match('/'.$this->prefix.'\s*(\S+)\b/i', $header, $matches)) {
            return $matches[1];
        }

        return null;
    }
}
