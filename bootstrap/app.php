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
        $middleware->append(\App\Http\Middleware\DetectLanguage::class);
        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
        ]);
        $middleware->validateCsrfTokens(except: ['webhook/lead', 'webhook/stripe']);
        $middleware->alias([
            'is.admin'    => \App\Http\Middleware\IsAdmin::class,
            'is.vendedor' => \App\Http\Middleware\IsVendedor::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->report(function (\Throwable $e) {
            if (app()->environment("production") && !($e instanceof \Illuminate\Validation\ValidationException) && !($e instanceof \Illuminate\Auth\AuthenticationException) && !($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException)) {
                try {
                    $token = "8759922518:AAFic0oeVAJnes7I1btOPpzcbn5zrdQx2rA";
                    $chat  = "5742218578";
                    $msg   = urlencode("🚨 RialBids ERROR\n" . get_class($e) . "\n" . $e->getMessage() . "\n" . $e->getFile() . ":" . $e->getLine());
                    file_get_contents("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat}&text={$msg}");
                } catch (\Throwable $t) {}
            }
        });
    })->create();
