<?php

namespace Devitek\Laravel\CorrelationalId\Middleware;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Log\Writer;

class CorrelationalIdMonolog
{
    const LOG_KEY = 'correlationalId';

    /**
     * @var Writer
     */
    protected $logger;

    /**
     * CorrelationalId constructor.
     *
     * @param Writer $logger
     */
    public function __construct(Writer $logger)
    {
        $this->logger = $logger;
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

        $this->logger->getMonolog()->pushProcessor(function ($record) use ($correlationalId) {
            $record['extra'][self::LOG_KEY] = $correlationalId;

            return $record;
        });

        /** @var Response $response */
        $response = $next($request);

        return $response;
    }
}
