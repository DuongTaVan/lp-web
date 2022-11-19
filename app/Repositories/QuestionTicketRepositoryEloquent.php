<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\QuestionTicketRepository;
use App\Models\QuestionTicket;
use App\Validators\QuestionTicketValidator;

/**
 * Class QuestionTicketRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class QuestionTicketRepositoryEloquent extends BaseRepository implements QuestionTicketRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return QuestionTicket::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
