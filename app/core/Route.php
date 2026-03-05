<?php

declare (strict_types = 1);

namespace App\Core;

use App\Controllers\ContactController;

class Route
{
    private string $uri;
    private string $method;

    public function __construct(string $uri, string $method)
    {
        $this->uri    = trim($uri);
        $this->method = strtoupper($method);
    }

    public function handle(): void
    {
        $currentUri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $currentUri    = rtrim($currentUri, '/');
        $currentMethod = strtoupper($_SERVER['REQUEST_METHOD']);

        // add / for root
        if ($currentUri === '') {
            $currentUri = '/';
        }

        // only for specific contact form route
        if ($this->uri === $currentUri && $this->method === $currentMethod) {
            $controller = new ContactController();
            $controller->handleRequest($currentMethod);
            return;
        }

        http_response_code(404);
        echo '404 Page Not Found';
    }

}
