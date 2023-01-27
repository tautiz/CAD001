<?php

namespace Appsas\Repositories;

use Appsas\Database;

class BaseRepository
{
    public function __construct(protected Database $db)
    {
    }
}