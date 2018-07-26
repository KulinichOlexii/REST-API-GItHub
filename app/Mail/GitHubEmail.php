<?php

namespace App\Mail;

use App\Service\ValueObject\GitHubUserResponse;
use App\Service\ValueObject\WeatherResponse;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GitHubEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var GitHubUserResponse $user
     */
    private $user;

    /**
     * @var WeatherResponse|null $weather
     */
    private $weather;

    /**
     * @var string $message
     */
    private $message;

    /**
     * @var string $platformName
     */
    private $platformName;

    /**
     * @var string $platformName
     */
    private $supportEmail;

    /**
     * GitHubEmail constructor.
     *GitHubUserResponse $user
     * @param WeatherResponse $weather
     * @param string $message
     * @param string $platformName
     * @param string $supportEmail
     */
    public function __construct(GitHubUserResponse $user, $weather, $message, $platformName, $supportEmail)
    {
        $this->user = $user;
        $this->weather = $weather;
        $this->message = $message;
        $this->platformName = $platformName;
        $this->supportEmail = $supportEmail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->supportEmail){
            dd($this->from($this->supportEmail, $this->platformName)->view('mail.gitHubEmailMessage', [
                'user' => $this->user, 'weather' => $this->weather, 'message' => $this->message]));
            return $this->from($this->supportEmail, $this->platformName)->view('mail.gitHubEmailMessage', [
                'user' => $this->user, 'weather' => $this->weather, 'message' => $this->message]);
        } else {
            return $this->view('mail.gitHubEmailMessage', ['user' => $this->user,
                'weather' => $this->weather, 'message' => $this->message]);
        }
    }
}