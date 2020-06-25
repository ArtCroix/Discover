<?php

namespace App\Http\Controllers;

use App\Src\ApplicationHelpers\CreateNewSubmitFromExistingOne;
use Illuminate\Http\Request;
use App\Src\ApplicationHandlers\SubmitHandler;
use App\Src\UserHandler;
use App\Models\Application\Submit;
use App\Src\ApplicationHandlers\AfterSubmitHandlers\TeamHandlers\InsertTeam;
use App\Src\ApplicationHandlers\ApplicationHandler;
use App\Src\ApplicationHelpers\PaymentHelper;
use App\Src\EventHandler;

class TestController extends Controller
{
    public function test(Request $request)
    {
        EventHandler::copyApplicationsToNewEvent(18);
    }
}
