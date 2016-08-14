<?php

namespace Devitek\Laravel\CorrelationalId\Middleware;

use Closure;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CorrelationalId
{
    const HEADER = 'X-Correlational-Id';

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
        $correlationalId = Uuid::uuid4()->toString();
        $correlationalId = $request->header(self::HEADER, $correlationalId);

        $request->attributes->add([
            self::HEADER => $correlationalId
        ]);

        /** @var Response $response */
        $response = $next($request);

        if ($response instanceof RedirectResponse) {
            /** @var RedirectResponse $response */
            $response->headers->add([
                self::HEADER => $correlationalId,
            ]);
        } else {
            $response->withHeaders([
                self::HEADER => $correlationalId,
            ]);
        }

        return $response;
    }
}
