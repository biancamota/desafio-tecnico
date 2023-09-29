<?php

namespace Bm\Store\Entity;

class User extends Entity
{
    public function toJsonArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email
        ];
    }

    public function setPasswordHash(string $password)
    {
        $this->attributes['password'] = password_hash($password, PASSWORD_ARGON2I);
    }
}
