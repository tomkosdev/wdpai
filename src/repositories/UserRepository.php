<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository
{

    public function getUser(string $email): ? User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT u.id, email, password, nickname, role FROM public.users u INNER JOIN details d ON u.detail = d.id WHERE email = :email');

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user == false) {
            return null;
        }

        return new User(
            $user['email'],
            $user['password'],
            $user['nickname'],
            $user['role'],
            $user['id']
        );
    }

    public function addUser(User $user)
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO public.details (email, password)
            VALUES (?, ?)');

        $stmt->execute([
            $user->getEmail(),
            $user->getPassword()
        ]);

        $stmt = $this->database->connect()->prepare('
            INSERT INTO public.users (nickname, detail)
            VALUES (?, ?)');

        $stmt->execute([
            $user->getNickname(),
            $this->getUserId($user)
        ]);
    }

    public function changePassword(User $user, string $new_password)
    {
        $stmt = $this->database->connect()->prepare('
        UPDATE public.details SET password = :password WHERE email = :email');

        $stmt->bindParam(':password', $new_password, PDO::PARAM_STR);
        $stmt->bindParam(':email', $user->getEmail(), PDO::PARAM_STR);
        $stmt->execute();   
    }

    public function getUserId(User $user): int
    {
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM public.details WHERE email = :email AND password = :password');

        $stmt->bindParam(':email', $user->getEmail(), PDO::PARAM_STR);
        $stmt->bindParam(':password', $user->getPassword(), PDO::PARAM_STR);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data['id'];
    }

    public function createSession(User $user) {
        $_SESSION['email'] = $user->getEmail();
        $_SESSION['nickname'] = $user->getNickname();
        $_SESSION['role'] = $user->getRole();
        $_SESSION['id'] = $user->getId();
    }
}