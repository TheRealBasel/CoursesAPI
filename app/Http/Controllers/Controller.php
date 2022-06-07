<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected $TEACHER_ROLE_ID;
    protected $STUDENT_ROLE_ID;
    protected $ADMIN_ROLE_ID;

    public function __construct(Type $var = null) {
        $this->ADMIN_ROLE_ID = 1;
        $this->TEACHER_ROLE_ID = 3;
        $this->STUDENT_ROLE_ID = 2;

    }
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
