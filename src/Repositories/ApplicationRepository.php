<?php

namespace App\Repositories;

class ApplicationRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct('application');
    }

    /**
     * Find all applications for a specific job.
     *
     * @param int $jobId
     * @return array
     */
    public function findByJob($jobId)
    {
        return $this->where(['job_id' => $jobId]);
    }

    /**
     * Find all applications submitted by a specific user.
     *
     * @param int $userId
     * @return array
     */
    public function findByUser($userId)
    {
        return $this->where(['user_id' => $userId]);
    }
}
