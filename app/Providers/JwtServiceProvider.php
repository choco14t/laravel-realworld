<?php

namespace App\Providers;

use App\Extensions\CustomAuthHeaders;
use Illuminate\Support\ServiceProvider;
use Tymon\JWTAuth\JWTAuth;

class JwtServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function boot()
    {
        $this->setCustomJwtParser();
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function setCustomJwtParser()
    {
        $jwtAuth = $this->app->make(JWTAuth::class);
        assert($jwtAuth instanceof JWTAuth);

        $parser = new CustomAuthHeaders();
        $jwtAuth->parser()->setChain(array_merge(
            $jwtAuth->parser()->getChain(),
            [$parser]
        ));
    }
}
