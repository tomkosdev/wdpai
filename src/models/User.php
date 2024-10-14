<?php

class User {
    private $id;
    private $email;
    private $password;
    private $nickname;
    private $role;

    public function __construct(string $email, string $password, string $nickname, $role = 2, $id = null) {
        $this->email = $email;
        $this->password = $password;
        $this->nickname = $nickname;
        $this->role = $role;
        $this->id = $id;
    }

    public function getEmail(): string 
    {
        return $this->email;
    }

    public function setEmail(string $email) 
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword(string $password) 
    {
        $this->password = $password;
    }

    public function getNickname()
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname) 
    {
        $this->nickname = $nickname;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getId()
    {
        return $this->id;
    } 
}