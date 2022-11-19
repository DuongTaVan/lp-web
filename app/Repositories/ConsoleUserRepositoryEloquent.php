<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ConsoleUserRepository;
use App\Models\ConsoleUser;
use App\Validators\ConsoleUserValidator;

/**
 * Class ConsoleUserRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ConsoleUserRepositoryEloquent extends BaseRepository implements ConsoleUserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ConsoleUser::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
