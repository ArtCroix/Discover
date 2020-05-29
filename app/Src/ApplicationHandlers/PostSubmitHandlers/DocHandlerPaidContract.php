<?php

namespace App\Src\ApplicationHandlers\PostSubmitHandlers;

use App\Src\ApplicationHandlers\PostSubmitHandlers\DocHandlerTrait;
use App\Src\ApplicationHandlers\PostSubmitHandlers\AbstractPostSubmitHandler;
use App\Src\ApplicationHelpers\PaymentHelper;
use App\Src\ApplicationHelpers\TeamHelper;
use App\Src\ApplicationHelpers\Num2String;
use Illuminate\Support\Facades\Storage;

class DocHandlerPaidContract extends AbstractPostSubmitHandler
{
    use DocHandlerTrait;

    public function __construct(array $applicationDataForUser)
    {
        parent::__construct($applicationDataForUser);
        $event_dir_name = $this->applicationDataForUser[0]->event_dir_name;
        $templatesDirectory = "events/{$event_dir_name}/applications/{$this->submit->application_id}/templates/{$this->locale}";
        $this->submitAdditionalData = $this->getSubmitAdditionalData(['created_docs' => []]);
        $this->submitAdditionalData->created_docs = $this->submitAdditionalData->created_docs ?? [];
        $this->resultsDirectory = "events/{$event_dir_name}/applications/{$this->submit->application_id}/users_data/{$this->user->id}/created_files";
        $this->resultsDirectoryFullPath = public_path() . "/storage/events/{$event_dir_name}/applications/{$this->submit->application_id}/users_data/{$this->user->id}/created_files";
        $this->templateFilesList = Storage::files($templatesDirectory);
        $this->getReplaceAndSearchData();
        $this->modifyReplaceData();
        $this->templatesDataGenerator = $this->readTemplates();
        Storage::makeDirectory($this->resultsDirectory);
    }


    public function modifyReplaceData()
    {
        $team = TeamHelper::getTeamForEvent($this->applicationDataForUser[0]->event_name, \Auth::user()->id);
        $total_price = PaymentHelper::calculatePriceForTeam($this->applicationDataForUser[0]->event_name, $team[0]->team_id);
        extract($this->replaceArray);

        $customer_initials = $customerlastname . ". " . mb_substr($customerfirstname, 0, 1) . ". " . (mb_substr($customermiddlename, 0, 1) != "" ? mb_substr($customermiddlename, 0, 1) . "." : "");

        $this->replaceArray["customerinitials"] = $customer_initials;
        $this->replaceArray["totalprice"] = $total_price;
        $this->replaceArray["paymentinwords"] = mb_convert_encoding(Num2String::num2String($total_price), 'Windows-1251', 'utf-8');
    }
}
