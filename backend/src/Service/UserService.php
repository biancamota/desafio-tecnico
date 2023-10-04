<?php

namespace Bm\Store\Service;

use Bm\Store\Entity\User;
use Bm\Store\Repository\UserRepository;

class UserService
{
    protected $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository;
    }

    public function getAll()
    {
        $data = $this->userRepository->getAll();
        $users = [];
        foreach ($data as $user) {
            $users[] = $user->toJsonArray();
        }
        return $users;
    }

    public function getById($args)
    {
        $user = $this->userRepository->getById($args['users']);

        return $user ? $user->toJsonArray() : null;
    }

    public function store($request)
    {
        $this->parsedDataRequest($request);
        $validationErrors = $this->validate($request);

        if (!empty($validationErrors)) {
            return ['errors' => $validationErrors];
        }
        
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->setPasswordHash($request->password);

        $this->userRepository->create($user);

        return [];
    }

    public function update($request, $args)
    {
        $user = $this->userRepository->getById($args['users']);

        if (!$user) {
            return ['User not found'];
        }
        $this->parsedDataRequest($request);
        $validationErrors = $this->validate($user);

        if (!empty($validationErrors)) {
            return ['errors' => $validationErrors];
        }

        $user->name = $request->name;
        $user->email = $request->email;

        if ($user->password) {
            $user->setPasswordHash($user->password);
        }

        $this->userRepository->update($args['users'], $user);

        return [];
    }

    public function delete($args)
    {
        $this->userRepository->delete($args['users']);

        return [];
    }

    private function validate($user): array
    {
        $errors = [];

        if (empty($user->name) || empty($user->email) || empty($user->password)) {
            $errors[] = 'All fields are required';
        }

        if (!filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'The email address is not valid';
        }

        $exists = $this->userRepository->getWhere('email', $user->email);
        if ($exists) {
            $errors[] = 'This email address is already in use by another user';
        }

        return $errors;
    }

    private function parsedDataRequest(&$request)
    {
        $request->name = trim($request->name);
        $request->email = trim($request->email);
    }
}
