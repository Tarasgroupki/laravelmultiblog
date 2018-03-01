<?php

namespace App\Listeners;

use App\Events\Laravelista\Comments\Events\CommentWasPosted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailToUsersWhoCommentedOnGivenContent
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CommentWasPosted  $event
     * @return void
     */
    public function handle(CommentWasPosted $event)
    {
         $comment = $event->comment;
    $users = $comment->getUsersWhoCommented();

    foreach($users as $user)
    {
        // send email to each user
    }
    }
}
