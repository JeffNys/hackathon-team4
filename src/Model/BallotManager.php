<?php

namespace App\Model;

class BallotManager extends AbstractManager
{
    private const TABLE = 'ballot';

    private const FIELDS = [
        'id',
        'id_loi',
        'date',
        'vote'
    ];

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
}