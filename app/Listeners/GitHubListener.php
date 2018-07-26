<?php

namespace App\Listeners;


use App\Events\GitHubEvent;
use App\Mail\GitHubEmail;
use Illuminate\Support\Facades\Mail;

class GitHubListener
{
    /**
     * SendShareNotification constructor.
     */
    public function __construct()
    {
        //
    }

    /**
     * @param GitHubEvent $event
     */
    public function handle(GitHubEvent $event)
    {
        $user = $event->getUser();
        $weather = $event->getWeather();
        $message = $event->getMessage();
        $platformName = $event->getPlatformName();
        $supportEmail = $event->getSupportEmail();

        if ($user && !empty($user->getEmail())) {
            Mail::to($user->getEmail())->send(new GitHubEmail($user, $weather, $message, $platformName, $supportEmail));
        }
    }
}