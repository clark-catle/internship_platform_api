<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\InternshipRequests\AddInternshipRequest;
use Illuminate\Http\Request;

class InternshipController extends Controller
{
    public function addInternship(AddInternshipRequest $request)
    {
        return $request->validated();
    }
}
