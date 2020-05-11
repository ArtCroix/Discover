<?php

namespace App\Src\ApplicationHandlers\PostSubmitHandlers;

use App\Src\ApplicationHandlers\PostSubmitHandlers\DocHandlerTrait;
use App\Src\ApplicationHandlers\PostSubmitHandlers\AbstractPostSubmitHandler;
use Illuminate\Support\Facades\Storage;

class DocHandler extends AbstractPostSubmitHandler
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
        $this->templatesDataGenerator = $this->readTemplates();
        Storage::makeDirectory($this->resultsDirectory);
    }
}
