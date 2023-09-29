<?php

namespace Bm\Store\Controller;

use Bm\Store\Entity\User;
use Bm\Store\Repository\UserRepository;
use Bm\Store\Util\JsonResponse;

class UserController
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
        return JsonResponse::send($users);
    }

    public function getById($args)
    {
        $user = $this->userRepository->getById($args['users']);
        if (!$user) {
            return JsonResponse::send('User not found', 404);
        }
        return JsonResponse::send($user->toJsonArray());
    }

    public function store($request)
    {
        $validationErrors = $this->validate($request);

        if (!empty($validationErrors)) {
            return JsonResponse::send(['errors' => $validationErrors], 400);
        }
        
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->setPasswordHash($request->password);

        $this->userRepository->create($user);

        return JsonResponse::send('User saved successfully', 201);
    }

    public function update($request, $args)
    {
        $user = $this->userRepository->getById($args['users']);

        if (!$user) {
            return JsonResponse::send('User not found', 404);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->setPasswordHash($request->password);
        }

        $this->userRepository->update($args['users'], $user);

        return JsonResponse::send('User updated successfully');
    }

    public function delete($args)
    {
        $user = $this->userRepository->getById($args['users']);

        if (!$user) {
            return JsonResponse::send('User not found', 404);
        }

        $this->userRepository->delete($args['users']);

        return JsonResponse::send('User deleted successfully');
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

        // Verificar se o e-mail é único
        $exists = $this->userRepository->getWhere('email', $user->email);
        if ($exists) {
            $errors[] = 'This email address is already in use by another user';
        }

        return $errors;
    }

}
