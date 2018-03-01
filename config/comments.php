<?php

return [

    /**
     * Enter models which can be commented upon.
     */
    'content' => [
        App\Posts::class,
		Laravelista\Lessons\Lesson::class,
        Laravelista\Archive\Post::class
    ],

    /**
     * Enter your user model.
     */
    'user_model' => App\User::class,

    /**
     * Get the path to the login route.
     */
    'login_path' => '/blog/public/login'
];
