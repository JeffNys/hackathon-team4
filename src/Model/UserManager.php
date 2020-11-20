<?php

namespace App\Model;

class UserManager extends AbstractManager
{
    protected const TABLE = 'account';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function addUser(array $user)
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " VALUES 
        (null, :email, :password, :firstname, :lastname, :id_verif, :id_cripte)");
        $statement->bindValue(':email', $user['email'], \PDO::PARAM_STR);
        $statement->bindValue(':password', md5($user['password']), \PDO::PARAM_STR);
        $statement->bindValue(':firstname', $user['firstname'], \PDO::PARAM_STR);
        $statement->bindValue(':lastname', $user['lastname'], \PDO::PARAM_STR);
        $statement->bindValue(':id_verif', $user['id_verif'], \PDO::PARAM_INT);
        $statement->bindValue(':id_cripte', md5($user['id_cripte']), \PDO::PARAM_INT);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
    public function login(array $login)
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . self::TABLE . " WHERE email=:email AND password=:password");
        $statement->bindValue(':email', $login['email'], \PDO::PARAM_STR);
        $statement->bindValue(':password', $login['password'], \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch();
    }

    public function updateUser(array $user): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE .
            " SET email= :email, password= :password, firstname= :firstname, lastname= :lastname WHERE id= :id");
        $statement->bindValue(':email', $user['email'], \PDO::PARAM_STR);
        $statement->bindValue(':password', md5($user['password']), \PDO::PARAM_STR);
        $statement->bindValue(':firstname', $user['firstname'], \PDO::PARAM_STR);
        $statement->bindValue(':lastname', $user['lastname'], \PDO::PARAM_STR);
        $statement->bindValue(':id', $user['id'], \PDO::PARAM_STR);

        return $statement->execute();
    }
    public function delete(int $id): void
    {
        $statement = $this->pdo->prepare("DELETE FROM " . self::TABLE . " WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }
}
