<?php

namespace Devitek\Laravel\CorrelationalId\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Response;
use Raven_Client;

class CorrelationalIdSentry
{
    const TAG_NAME = 'correlationalId';

    /**
     * @var Application
     */
    protected $application;

    /**
     * CorrelationalIdSentry constructor.
     *
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $correlationalId = $request->attributes->get(CorrelationalId::HEADER);

        if ($this->application->bound('sentry')) {
            /** @var Raven_Client $sentry */
            $sentry = $this->application->make('sentry');

            $sentry->tags_context([
                self::TAG_NAME => $correlationalId,
            ]);
        }

        /** @var Response $response */
        $response = $next($request);

        return $response;
    }
}
