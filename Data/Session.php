<?php

namespace Akmal\LoginSystem\Data;

class Session
{
    private string $id;
    private string $user_username;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUserUsername(): string
    {
        return $this->user_username;
    }

    /**
     * @param string $user_username
     */
    public function setUserUsername(string $user_username): void
    {
        $this->user_username = $user_username;
    }


}