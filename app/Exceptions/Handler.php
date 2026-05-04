<?php

namespace App\Exceptions;

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (QueryException $e, $request) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'data'            => [],
                    'recordsTotal'    => 0,
                    'recordsFiltered' => 0,
                    'message'         => 'Demo mode.',
                ], 200);
            }

            // Cegah infinite loop: jika sudah di dashboard atau root, tampilkan pesan sederhana
            $path = ltrim($request->getPathInfo(), '/');
            if ($path === 'dashboard' || $path === '') {
                return response('<div style="font-family:sans-serif;padding:40px;text-align:center">
                    <h2>Demo Mode</h2>
                    <p>Beberapa data tidak tersedia di mode demo.</p>
                    <a href="/dashboard">Kembali ke Dashboard</a>
                </div>', 200);
            }

            // Halaman lain: kembali ke halaman sebelumnya
            return redirect()->back()->with('demo_warning', 'Fitur ini tidak tersedia di mode demo.');
        });
    }
}
