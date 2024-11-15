<?php

namespace App\Repositories;

class JobCategoryRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct('job_categories');
    }

    /**
     * Find a job category by name.
     *
     * @param string $name
     * @return array|null
     */
    public function findByName($name)
    {
        return $this->findBy('name', $name);
    }
}
