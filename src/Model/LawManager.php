<?php

namespace App\Model;

class LawManager extends AbstractManager
{
    const TABLE = 'law';

    const FIELDS = [
        'id',
        'url_loi',
        'date_vote'
    ];

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function findByUrl(string $url)
    {
        $sql = "SELECT * FROM $this->table WHERE url_loi=?";
        $query = $this->pdo->prepare($sql);
        $query->execute(['$url']);
        return $query->fetch();
    }
}