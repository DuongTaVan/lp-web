<?php

namespace App\Services\Portal;

/**
 * Abstract Class BaseService
 *
 * @package App\Portal\Services
 */
abstract class BaseService
{
    /**
     * @var $repository
     */
    public $repository;

    /**
     * HomeService constructor.
     */
    public function __construct()
    {
        $this->repository = app($this->repository());
    }

    /**
     * Abstract repository
     *
     * @return string
     */
    public abstract function repository();
}