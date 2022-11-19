<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Client\Student\Course\CourseReviewService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * home
     * @param CourseReviewService $service
     * @return view home
     */
    public function index(CourseReviewService $service)
    {

        return view('client.screen.home');
    }

    /**
     * search
     *
     * @return view search
     */
    public function search()
    {
        return view('client.screen.search');
    }

}
