<?php

namespace App\Src\ApplicationHandlers\PostSubmitHandlers;

use App\Src\ApplicationHandlers\PostSubmitHandlers\DocHandlerTrait;
use App\Src\ApplicationHandlers\PostSubmitHandlers\AbstractPostSubmitHandler;
use Illuminate\Support\Facades\Storage;

class DocHandlerInvitation extends AbstractPostSubmitHandler
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
        extract($this->replaceArray);
        $fio_1 = "";
        $fio_2 = "";
        $fio_3 = "";
        $coach_fio = "";
        $fio_1 = $firstname_1 . " " . $lastname_1 . " " . $middlename_1;
        $fio_2 = $firstname_2 . " " . $lastname_2 . " " . $middlename_2;
        $fio_3 = $firstname_3 . " " . $lastname_3 . " " . $middlename_3;
        $fio_1 = $fio_1 !== "  " ? trim($fio_1) . "," : "";
        $fio_2 = $fio_2 !== "  " ? trim($fio_2) . "," : "";
        $fio_3 = $fio_3 !== "  " ? trim($fio_3) . "," : "";
        $coach_fio = $coach_firstname . " " . $coach_lastname . " " . $coach_middlename;

        $this->replaceArray["firstparticipant"] = $fio_1;
        $this->replaceArray["secondparticipant"] = $fio_2;
        $this->replaceArray["thirdparticipant"] = $fio_3;
        $this->replaceArray["coachfio"] = $coach_fio;
    }
}
