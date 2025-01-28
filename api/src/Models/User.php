<?php

namespace Api\Models;

class User
{
    private static $users = [
        1 => ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com'],
        2 => ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com'],
    ];

    public static function find($id)
    {
        return self::$users[$id] ?? null;
    }
}
