<?php

use App\Http\Middleware\LogTimeMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/users/list', function () {
    $users = App\Models\User::all();
    return view('users.list', ['users' => $users]);
})
    ->middleware(LogTimeMiddleware::class)
    ->name('users.list');

Route::get('/logs', function () {
    $logs = App\Models\Log::orderBy('id', 'desc')->get();

    $percentiles = [];
    $percentilesHeaders = ["Sample size", "99%", "5%", "Max", "Min"];
    foreach ($logs->groupBy('path') as $path => $pathGroup) {
        $percentiles[$path] = [
            "Sample size" => $pathGroup->count(),
            "99%" => round(percentile($pathGroup->pluck('time')->toArray(), 99, true), 2),
            "5%" => round(percentile($pathGroup->pluck('time')->toArray(), 5, true), 2),
            "Max" => round($pathGroup->pluck('time')->max(), 2),
            "Min" => round($pathGroup->pluck('time')->min(), 2),
        ];
    }

    return view('logs', [
        'logs' => $logs,
        'percentiles' => $percentiles,
        'percentilesHeaders' => $percentilesHeaders,
    ]);
})->name('logs');

Route::get('/mandelbrot', function () {
    $h = 1200;
    $w = $h;

    $bit_num = 128;
    $byte_acc = 0;

    $yfac = 2.0 / $h;
    $xfac = 2.0 / $w;

    for ($y = 0; $y < $h; ++$y) {
        $result = ['c*'];

        $Ci = $y * $yfac - 1.0;

        for ($x = 0; $x < $w; ++$x) {
            $Zr = 0;
            $Zi = 0;
            $Tr = 0;
            $Ti = 0.0;

            $Cr = $x * $xfac - 1.5;

            do {
                for ($i = 0; $i < 50; ++$i) {
                    $Zi = 2.0 * $Zr * $Zi + $Ci;
                    $Zr = $Tr - $Ti + $Cr;
                    $Tr = $Zr * $Zr;
                    if (($Tr + ($Ti = $Zi * $Zi)) > 4.0) break 2;
                }
                $byte_acc += $bit_num;
            } while (FALSE);

            if ($bit_num === 1) {
                $result[] = $byte_acc;
                $bit_num = 128;
                $byte_acc = 0;
            } else {
                $bit_num >>= 1;
            }
        }
        if ($bit_num !== 128) {
            $result[] = $byte_acc;
            $bit_num = 128;
            $byte_acc = 0;
        }
    }

    return response()->json($result);
})
    ->middleware(LogTimeMiddleware::class)
    ->name('mandelbrot');

Route::get('/', function () {
    return view('welcome', [
        'links' => [
            [
                'name' => 'SQL Select of 100 rows',
                'href' => route('users.list')
            ],
            [
                'name' => 'Mandelbrot',
                'href' => route('mandelbrot')
            ]
        ]
    ]);
});
