<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Src\ApplicationHandlers\SubmitHandler;

class SubmitController extends Controller
{
    public static function doDeleteFileFromApplicationSubmit(Request $request)
    {
        SubmitHandler::deleteFileFromApplicationSubmit($request);
    }
}
