<?php

namespace App\Services;

abstract class BaseService
{
    /**
     * A Repository Object Instance.
     */
    protected $repository;

    /**
     * Get all.
     *
     * @return mixed
     */
    public function all()
    {
        return $this->repository->all();
    }

    /**
     * Find by id or fail.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function findOrFail(int $id)
    {
        return $this->repository->findOrFail($id);
    }

    /**
     * Create function.
     *
     * @param array $array
     *
     * @return mixed
     */
    public function create(array $array)
    {
        return $this->repository->create($array);
    }

    /**
     * Get where.
     *
     * @param array $array
     *
     * @return mixed
     */
    public function where(array $array)
    {
        return $this->repository->where($array);
    }
}
