<?php

declare (strict_types = 1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Models\ContactModel;
use App\Services\EmailService;
use App\Views\View;

class ContactController
{
    private ContactModel $model;
    private Csrf $csrf;
    private View $view;

    public function __construct()
    {
        $this->model = new ContactModel();
        $this->csrf  = new Csrf();
        $this->view  = new View();
    }

    /**
     * Initial data
     */
    private function initData(): array
    {
        return [
            'values'     => [],
            'errors'     => [],
            'message'    => [],
            'csrf_token' => $this->csrf->getToken(),
        ];

    }

    /**
     * Handle request
     */
    public function handleRequest(string $method): void
    {
        $data = $this->initData();

        if ($method === 'POST') {
            $data = $this->handlePost($_POST, $data);
        }

        $this->renderView($data);

    }

    /**
     * Handle POST request
     */
    private function handlePost(array $postData, array $data): array
    {
        $submittedToken = $postData['csrf_token'] ?? '';

        if (! $this->csrf->validate($submittedToken)) {
            $data['message'] = [
                'status' => 'error',
                'text'   => 'Invalid CSRF token. Please try again.',
            ];
            return $data;
        }

        $this->model->setData($postData);

        if (! $this->model->validate()) {
            return $this->handleValidationFailure($data);
        }

        return $this->handleFormSubmission($data);

    }

    /**
     * Validation failure
     */
    private function handleValidationFailure(array $data): array
    {
        $data['errors'] = $this->model->getErrors();
        $data['values'] = $this->model->getSanitisedData();
        return $data;

    }

    /**
     * Form submission
     */
    private function handleFormSubmission(array $data): array
    {
        $formData     = $this->model->getData();
        $emailService = new EmailService();

        $sent = $emailService
            ->setTo('admin@example.com')
            ->setSubject($formData['reason'])
            ->setBody(
                "Name: " . $formData['name'] . "\n" .
                "Email: " . $formData['email'] . "\n" .
                "Message: " . $formData['message']
            )
            ->addHeader('From', $formData['email'])
            ->addHeader('Reply-To', $formData['email'])
            ->send();

        if ($sent) {
            $data['message'] = [
                'status' => 'success',
                'text'   => 'Your message has been sent successfully.',
            ];
        } else {
            $data['message'] = [
                'status' => 'error',
                'text'   => 'Sorry, we could not send your message. Please try again later.',
            ];
            $data['values'] = $this->model->getSanitisedData();
        }

        // destroy old token and regenerate new
        $this->csrf->destroy();
        $data['csrf_token'] = $this->csrf->getToken();

        return $data;

    }

    /**
     * Render view
     */
    private function renderView(array $data): void
    {
        $this->view->render($data, 'ContactForm');
    }

}
