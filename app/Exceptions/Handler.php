<?php

namespace Square\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Square\Services\LogService;

class Handler extends ExceptionHandler
{

    private $log;

    public function __construct(Container $container, LogService $service)
    {
        parent::__construct($container);
        $this->log = $service;

    }

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {

        $response = [
            'error' => true
        ];

        $statusCode = ($exception->getCode() == 0 || $exception->getCode() == 1) ? 400 : $exception->getCode();

        // Add the exception class name, message and stack trace to response
        $response['exception'] = get_class($exception); // Reflection might be better here
        $response['message'] = $exception->getMessage();

        $data = array();
        $data['uri'] = $request->getUri();
        $data['request'] = $request->all();
        $data['ip_client'] = $request->getClientIp();
        $data['exception'] = get_class($exception);
        $data['message'] = $exception->getMessage();
        $data['code'] = $statusCode;

        $this->log->create($data);

        // Return a JSON response with the response array and status code
        return response()->json($response, $statusCode);

    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }
}
