<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Simple PHP MVC Contact form">
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>Contact Form</h1>

            <?php if (! empty($data['message'])): ?>
                <div class="alert alert-<?php echo $data['message']['status'] === 'success' ? 'success' : 'danger'; ?>">
                    <?php echo $data['message']['text']; ?>
                </div>
            <?php endif; ?>

            <form id="contact-form" action="#" method="POST">

                <!-- Name -->
                <div class="form-row">
                    <label>
                        Name
                        <input
                            type="text"
                            name="name"
                            class="form-element"
                            value="<?php echo $data['values']['name'] ?? ''; ?>"
                        >
                        <span class="error name-error">
                            <?php echo $data['errors']['name'] ?? ''; ?>
                        </span>
                    </label>
                </div>

                <!-- Email -->
                <div class="form-row">
                    <label>
                        Email
                        <input
                            type="email"
                            name="email"
                            class="form-element"
                            value="<?php echo $data['values']['email'] ?? ''; ?>"
                        >
                        <span class="error email-error">
                            <?php echo $data['errors']['email'] ?? ''; ?>
                        </span>
                    </label>
                </div>

                <!-- Reason -->
                <div class="form-row">
                    <label>
                        Reason for Enquiry
                        <input
                            type="text"
                            name="reason"
                            class="form-element"
                            value="<?php echo $data['values']['reason'] ?? ''; ?>"
                        >
                        <span class="error reason-error">
                            <?php echo $data['errors']['reason'] ?? ''; ?>
                        </span>
                    </label>
                </div>

                <!-- Message -->
                <div class="form-row">
                    <label>
                        Message
                        <textarea
                            name="message"
                            class="form-element"
                        ><?php echo $data['values']['message'] ?? ''; ?></textarea>
                        <span class="error message-error">
                            <?php echo $data['errors']['message'] ?? ''; ?>
                        </span>
                    </label>
                </div>

                <!-- Submit -->
                <div class="form-row">
                    <input
                        type="hidden"
                        name="csrf_token"
                        value="<?php echo htmlspecialchars($data['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                    >
                    <button type="submit">Submit</button>
                </div>

            </form>
        </div>
    </div>

    <script src="/public/js/main.js"></script>

</body>
</html>