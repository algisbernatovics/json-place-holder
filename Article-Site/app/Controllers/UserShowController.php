<?php

namespace App\Controllers;

use App\Core\Renderer;
use App\Services\Articles\Show\ArticleRequest;
use App\Services\Articles\Show\ArticleService;
use App\Services\Users\Show\UserRequest;
use App\Services\Users\Show\UserService;

class UserShowController
{
    private object $userService;
    private object $userArticleService;

    public function __construct(UserService $userService, ArticleService $userArticleService)
    {
        $this->userService = $userService;
        $this->userArticleService = $userArticleService;
    }

    public function allUsers(): string
    {
        $userResponse = $this->userService->execute();
        return (new Renderer())->showAllUsers(
            'ShowAllUsers.twig',
            $userResponse->getResponse()->getUsers());
    }

    public function singleUser(): string
    {
        $userRequest = new UserRequest($_SERVER["REQUEST_URI"]);
        $userResponse = $this->userService->execute();

        $userArticleRequest = new ArticleRequest($_SERVER["REQUEST_URI"]);
        $userArticleResponse = $this->userArticleService->execute();
        return (new Renderer())->showSingleUser(
            'ShowSingleUser.twig',
            $userResponse->getResponse()->getSingleUser($userRequest->getUri()),
            $userArticleResponse->getResponse()->getUserArticles($userArticleRequest->getUri())
        );
    }
}