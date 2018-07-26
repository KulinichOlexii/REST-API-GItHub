<?php


namespace App\Service\ValueObject;

class GitHubUserResponse
{
    /**
     * @var string|null
     */
    private $email;

    /**
     * @var string|null
     */
    private $location;

    /**
     * GitHubUserResponse constructor.
     * @param string $email
     * @param string $location
     */
    public function __construct($email, $location)
    {
        $this->email = $email;
        $this->location = $location;
    }

    /**
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param null|string $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return null|string
     */
    public function getLocation(): ?string
    {
        return $this->location;
    }

    /**
     * @param null|string $location
     */
    public function setLocation(?string $location): void
    {
        $this->location = $location;
    }

    /**
     * @param string $json
     * @return static
     */
    public static function createFromJson(string $json)
    {
        $data = json_decode($json, true);

        $email = null;
        if (isset($data['email'])) {
            $email = (string) $data['email'];
        }

        $location = null;
        if (isset($data['location'])) {
            $location = (string) $data['location'];
        }

        $obj = new static($email, $location);

        return $obj;
    }
}