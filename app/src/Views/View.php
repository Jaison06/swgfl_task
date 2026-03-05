<?php

declare (strict_types = 1);

namespace App\Views;

class View
{
    public function render(array $data, string $template): void
    {
        $templatePath = BASE_PATH . '/app/templates/' . $template . '.php';

        if (! file_exists($templatePath)) {
            throw new \RuntimeException(
                "template not found."
            );
        }

        require $templatePath;
    }
}
