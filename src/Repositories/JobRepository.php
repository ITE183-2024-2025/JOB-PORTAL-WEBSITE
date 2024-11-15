<?php

namespace App\Repositories;

class JobRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct('job');
    }

    /**
     * Find all jobs created by a specific user.
     *
     * @param int $userId
     * @return array
     */
    public function findByCreator($userId)
    {
        return $this->where(['created_by' => $userId]);
    }

    /**
     * Find jobs by category ID.
     *
     * @param int $categoryId
     * @return array
     */
    public function findByCategory($categoryId)
    {
        return $this->where(['job_category_id' => $categoryId]);
    }
}
