<?php

namespace Appsas\Repositories;

use Appsas\Models\Person;

class PersonsRepository extends BaseRepository implements RepositoryInterface
{
    protected const TABLE_NAME = 'persons';
    protected const MODEL_CLASS = Person::class;
}