<?php

namespace App\Http\Controllers\Client\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class LogController extends Controller
{

    public function write(Request $request)
    {
		$log = new Logger('View Logs');
		$log->pushHandler(new StreamHandler(storage_path('logs/javascript.log'), Logger::INFO));
		$log->addInfo($request->get('msg'), [
			'ip' => request()->ip(),
			'url' => $request->get('url'),
        	'error' => $request->get('err'),
		]);
		return $request->get('msg');
    }
}
