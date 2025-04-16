<?php

namespace Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController
{
    public static function login(Request $request, Response $response, array $args): Response
    {
        global $USER;

        $params = (array)$request->getParsedBody();

        $email = $params['email'] ?? '';
        $password = $params['password'] ?? '';


        if (empty($email) || empty($password)) {
            return self::json($response, ['status' => 'error', 'message' => 'Email и пароль обязательны'], 400);
        }

        $authResult = $USER->Login($email, $password);
        if ($authResult === true) {
            return self::json($response, ['status' => 'success', 'message' => 'Авторизация успешна']);
        }

        return self::json($response, ['status' => 'error', 'message' => 'Неверный логин или пароль'], 401);
    }

    public static function logout(Request $request, Response $response, array $args): Response
    {
        global $USER;

        if ($USER->IsAuthorized()) {
            $USER->Logout();
            return self::json($response, ['status' => 'success', 'message' => 'Вы успешно вышли']);
        }

        return self::json($response, ['status' => 'error', 'message' => 'Вы не авторизованы'], 401);
    }

    //@TODO Удалить если не будет реализован метод
    public static function profile(Request $request, Response $response, array $args): Response
    {
        global $USER;

        if (!$USER->IsAuthorized()) {
            return self::json($response, ['status' => 'error', 'message' => 'Вы не авторизованы'], 401);
        }

        $userId = $USER->GetID();
        $userData = \CUser::GetByID($userId)->Fetch();

        if (!$userData) {
            return self::json($response, ['status' => 'error', 'message' => 'Пользователь не найден'], 404);
        }

        //@TODO Нужно вернуть роль ?
        return self::json($response, [
            'status' => 'success',
            'user' => [
                'id' => $userData['ID'],
                'email' => $userData['EMAIL'],
                'name' => $userData['NAME'],
                'last_name' => $userData['LAST_NAME'],
            ]
        ]);
    }

    /**
     * Генерация случайного пароля
     */
    private static function generatePassword($length = 10): string
    {
        return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, $length);
    }

    private static function json(Response $response, array $data, int $status = 200): Response
    {
        $response->getBody()->write(json_encode($data, JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
    }

    public static function restore(Request $request, Response $response, array $args): Response
    {
        global $APPLICATION;

        $params = (array)$request->getParsedBody();
        $email = trim($params['email'] ?? '');

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return self::json($response, ['status' => 'error', 'message' => 'Некорректный email'], 400);
        }

        // Проверяем есть ли такой пользователь
        $user = \CUser::GetList(
            ($by = "id"),
            ($order = "asc"),
            ['=EMAIL' => $email]
        )->Fetch();

        if (!$user) {
            return self::json($response, ['status' => 'error', 'message' => 'Пользователь с таким email не найден'], 404);
        }

        $userId = $user['ID'];
        $newPassword = self::generatePassword();

        $userObj = new \CUser;
        $updateResult = $userObj->Update($userId, ['PASSWORD' => $newPassword, 'CONFIRM_PASSWORD' => $newPassword]);

        if (!$updateResult) {
            return self::json($response, ['status' => 'error', 'message' => 'Ошибка при обновлении пароля'], 500);
        }

        // Отправка письма с новым паролем
        $eventFields = [
            "USER_ID" => $userId,
            "EMAIL" => $email,
            "NEW_PASSWORD" => $newPassword,
            "SITE_NAME" => $_SERVER['SERVER_NAME']
        ];

        \CEvent::Send("USER_PASSWORD_RESTORE", SITE_ID, $eventFields);

        return self::json($response, [
            'status' => 'success',
            'message' => 'Новый пароль отправлен на ваш email'
        ]);
    }
}
