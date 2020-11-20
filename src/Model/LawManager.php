<?php

namespace App\Model;

class LawManager extends AbstractManager
{
    private const TABLE = 'law';

    private const FIELDS = [
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
        $query->execute([$url]);
        return $query->fetch();
    }

    public function statusOf(int $law)
    {
        $sql = "SELECT ballot.id AS idb, ballot.vote, pseudo.id AS idp, law.*
        FROM ballot JOIN pseudo ON pseudo.id_bulletin=ballot.id
        AND pseudo JOIN law ON pseudo.id_loi=law.id
        WHERE law.id=$law";
        return $this->pdo->query($sql)->fetchAll();
    }
}
