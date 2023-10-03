<?php

namespace Bm\Store\Controller;

use Bm\Store\Entity\User;
use Bm\Store\Service\UserService;
use Bm\Store\Util\JsonResponse;

class UserController
{
    protected $userService;

    public function __construct()
    {
        $this->userService = new UserService;
    }

    public function getAll()
    {
        $users = $this->userService->getAll();

        return JsonResponse::send($users);
    }

    public function getById($args)
    {
        $user = $this->userService->getById($args['users']);
        if (!$user) {
            return JsonResponse::send('User not found', 404);
        }
        return JsonResponse::send($user);
    }

    public function store($request)
    {
        $response = $this->userService->store($request);

        if (!empty($response)) {
            return JsonResponse::send($response, 400);
        }

        return JsonResponse::send('User saved successfully', 201);
    }

    public function update($request, $args)
    {
        $user = $this->userService->getById($args['users']);

        if (!$user) {
            return JsonResponse::send('User not found', 404);
        }

        $this->userService->update($args['users'], $user);

        return JsonResponse::send('User updated successfully');
    }

    public function delete($args)
    {
        $user = $this->userService->getById($args['users']);

        if (!$user) {
            return JsonResponse::send('User not found', 404);
        }

        $this->userService->delete($args['users']);

        return JsonResponse::send('User deleted successfully');
    }
}
