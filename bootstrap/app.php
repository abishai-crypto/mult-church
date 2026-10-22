<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->trustProxies(at: '*');

        $middleware->web(append: [
            \App\Http\Middleware\IdentifyTenant::class,
        ]);

        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (\Illuminate\Session\TokenMismatchException $e, \Illuminate\Http\Request $request) {
            return redirect()->route('login')
                ->withInput($request->except('password', 'password_confirmation', '_token'))
                ->with('info', 'Muda wa fomu uliisha kwa usalama (Session Expired). Tafadhali ingiza nenosiri lako tena kuendelea.');
        });

        $exceptions->render(function (\Throwable $e, \Illuminate\Http\Request $request) {
            \Illuminate\Support\Facades\Log::error($e->getMessage(), ['exception' => $e]);
            if (config('app.debug')) {
                return response("<div style='font-family:sans-serif;max-width:800px;margin:50px auto;padding:30px;background:#fff;border-radius:16px;box-shadow:0 10px 30px rgba(0,0,0,0.1);border-left:6px solid #e11d48;'><h3 style='color:#e11d48;margin-top:0;'>Hitilafu ya Mfumo (Taarifa za Kiufundi):</h3><p><strong>Ujumbe:</strong> " . htmlspecialchars($e->getMessage()) . "</p><p><strong>Faili:</strong> " . htmlspecialchars($e->getFile()) . " (Mstari: " . $e->getLine() . ")</p><hr style='border:0;border-top:1px solid #e2e8f0;margin:20px 0;'><a href='/dashboard' style='background:#1e3a8a;color:#fff;padding:10px 20px;text-decoration:none;border-radius:20px;font-weight:bold;display:inline-block;margin-right:10px;'>Fungua Dashibodi</a><a href='/logout' style='background:#f1f5f9;color:#334155;padding:10px 20px;text-decoration:none;border-radius:20px;font-weight:bold;display:inline-block;'>Toka Kwenye Mfumo (Logout)</a></div>", 500);
            }
        });
    })->create();
