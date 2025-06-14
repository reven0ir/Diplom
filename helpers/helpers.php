<?php

function app(): \PHPFramework\Application
{
    return \PHPFramework\Application::$app;
}

function view($view = '', $data = [], $layout = ''): string|\PHPFramework\View
{
    if (false !== $layout) {
        $layout = $layout ?: app()->layout;
    }
    if ($view) {
        return app()->view->render($view, $data, $layout);
    }
    return app()->view;
}

function request(): \PHPFramework\Request
{
    return app()->request;
}

function response(): \PHPFramework\Response
{
    return app()->response;
}

function base_url($path = ''): string
{
    return PATH . $path;
}

function h($str): string
{
    return htmlspecialchars($str, ENT_QUOTES);
}

/*function old($fieldname): string
{
    return isset($_POST[$fieldname]) ? h($_POST[$fieldname]) : '';
}*/

function old($fieldname): string
{
    return isset(session()->get('form_data')[$fieldname]) ? h(session()->get('form_data')[$fieldname]) : '';
}

function selected($fieldname, $value, $data = []): string
{
    $data = $data ?: session()->get('form_data');
    if (isset($data[$fieldname])) {
        if (is_array($data[$fieldname])) {
            return in_array($value, $data[$fieldname]) ? 'selected' : '';
        } else {
            return $data[$fieldname] == $value ? 'selected' : '';
        }
    }
    return '';
}

function get_errors($fieldname, $errors = []): string
{
    $output = '';
    if (isset($errors[$fieldname])) {
        $output .= '<div class="invalid-feedback d-block"><ul class="list-unstyled">';
        foreach ($errors[$fieldname] as $error) {
            $output .= "<li>{$error}</li>";
        }
        $output .= '</ul></div>';
    }
    return $output;
}

function get_validation_class($fieldname, $errors = []): string
{
    if (empty($errors)) {
        return '';
    }
    return isset($errors[$fieldname]) ? 'is-invalid' : 'is-valid';
}

/**
 * @return no-return
 */
function abort($error = '', $code = 404)
{
    response()->setResponseCode($code);
    if (DEBUG || $code = 404) {
        echo view("errors/{$code}", ['error' => $error], false);
    }
    die;
}

function db(): \PHPFramework\Database
{
    return app()->db;
}

function session(): \PHPFramework\Session
{
    return app()->session;
}

function router(): \PHPFramework\Router
{
    return app()->router;
}

function cache(): \PHPFramework\Cache
{
    return app()->cache;
}

function get_alerts(): void
{
    if (!empty($_SESSION['flash'])) {
        foreach ($_SESSION['flash'] as $k => $v) {
            echo view()->renderPartial("incs/alert_{$k}", ["flash_{$k}" => session()->getFlash($k)]);
        }
    }
}

function get_file_ext($file_name): string
{
    $file_ext = explode('.', $file_name);
    return end($file_ext);
}

function upload_file($file, $i = false, $path = false): string|false
{
    $file_ext = (false === $i) ? get_file_ext($file['name']) : get_file_ext($file['name'][$i]);
    $dir = '/' . date("Y") . '/' . date("m") . '/' . date("d");
    if (!is_dir(UPLOADS . $dir)) {
        mkdir(UPLOADS . $dir, 0755, true);
    }
    $file_name = md5(((false === $i) ? $file['name'] : $file['name'][$i]) . time());
    $file_path = UPLOADS . "{$dir}/{$file_name}.{$file_ext}";
    $file_url = base_url("/uploads{$dir}/{$file_name}.{$file_ext}");
    if (move_uploaded_file((false === $i) ? $file['tmp_name'] : $file['tmp_name'][$i], $file_path)) {
        if ($path) {
            return $file_path;
        }
        return $file_url;
    } else {
        error_log("[" . date('Y-m-d H:i:s') . "] Error uploading file" . PHP_EOL, 3, ERROR_LOG_FILE);
        return false;
    }
}

function check_auth(): bool
{
    return session()->has('user');
}

function is_admin(): bool
{
    return check_auth() && (session()->get('user')['role'] == 1);
}

function send_mail(array $to, string $subject, string $body, array $attachments = []): bool
{
    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = EMAIL['debug'];
        $mail->isSMTP();
        $mail->Host = EMAIL['host'];
        $mail->SMTPAuth = EMAIL['auth'];
        $mail->Username = EMAIL['username'];
        $mail->Password = EMAIL['password'];
        $mail->SMTPSecure = EMAIL['secure'];
        $mail->Port = EMAIL['port'];

        //Recipients
        $mail->setFrom(EMAIL['from_email']);
        foreach ($to as $email) {
            $mail->addAddress($email);
        }

        //Attachments
        if ($attachments) {
            foreach ($attachments as $attachment) {
                $mail->addAttachment($attachment);
            }
        }

        //Content
        $mail->isHTML(EMAIL['is_html']);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->CharSet = EMAIL['charset'];
        return $mail->send();
    } catch (\PHPMailer\PHPMailer\Exception $e) {
        error_log("[" . date('Y-m-d H:i:s') . "] Mail Error: {$mail->ErrorInfo}" . PHP_EOL, 3, ERROR_LOG_FILE);
        return false;
    }
}
