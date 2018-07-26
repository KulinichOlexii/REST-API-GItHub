<?php

namespace App\Events;

use App\Service\ValueObject\GitHubUserResponse;
use App\Service\ValueObject\WeatherResponse;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Queue\SerializesModels;

class GitHubEvent
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var GitHubUserResponse $user
     */
    private $user;

    /**
     * @var WeatherResponse|null $weather
     */
    private $weather;

    /**
     * @var string|null $message
     */
    private $message;

    /**
     * @var string|null $platformName
     */
    private $platformName;

    /**
     * @var string|null $platformName
     */
    private $supportEmail;

    /**
     * Create a new event instance.
     *
     * GitHubEvent constructor.
     * @param GitHubUserResponse $user
     * @param WeatherResponse|null $weather
     * @param string $message
     * @param string $platformName
     * @param string $supportEmail
     */
    public function __construct(GitHubUserResponse $user, $weather, $message, $platformName, $supportEmail)
    {
        $this->setUser($user);
        $this->setWeather($weather);
        $this->setMessage($message);
        $this->setPlatformName($platformName);
        $this->setSupportEmail($supportEmail);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }

    /**
     * @return GitHubUserResponse
     */
    public function getUser(): GitHubUserResponse
    {
        return $this->user;
    }

    /**
     * @param GitHubUserResponse $user
     */
    public function setUser(GitHubUserResponse $user): void
    {
        $this->user = $user;
    }

    /**
     * @return WeatherResponse|null
     */
    public function getWeather(): ?mixed
    {
        return $this->weather;
    }

    /**
     * @param WeatherResponse|null $weather
     */
    public function setWeather(?WeatherResponse $weather): void
    {
        $this->weather = $weather;
    }

    /**
     * @return null|string
     */
    public function getPlatformName(): ?string
    {
        return $this->platformName;
    }

    /**
     * @param null|string $platformName
     */
    public function setPlatformName(?string $platformName): void
    {
        $this->platformName = $platformName;
    }

    /**
     * @return null|string
     */
    public function getSupportEmail(): ?string
    {
        return $this->supportEmail;
    }

    /**
     * @param null|string $supportEmail
     */
    public function setSupportEmail(?string $supportEmail): void
    {
        $this->supportEmail = $supportEmail;
    }

    /**
     * @return null|string
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param null|string $message
     */
    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }
}