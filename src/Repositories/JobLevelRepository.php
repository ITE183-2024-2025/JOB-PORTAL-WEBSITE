<?php

namespace App\Repositories;

class JobLevelRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct('job_level');
    }

    /**
     * Find a job level by name.
     *
     * @param string $name
     * @return array|null
     */
    public function findByName($name)
    {
        return $this->findBy('name', $name);
    }
}
