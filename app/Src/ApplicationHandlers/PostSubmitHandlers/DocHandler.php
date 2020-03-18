<?php

namespace App\Src\ApplicationHandlers\PostSubmitHandlers;

use App\Src\ApplicationHandlers\PostSubmitHandlers\AbstractPostSubmitHandler;
use Illuminate\Support\Facades\Storage;

class DocHandler extends AbstractPostSubmitHandler
{
    protected $resultsDirectory;
    protected $resultsDirectoryFullPath;
    protected $templateFilesList;
    protected $templatesDataGenerator;
    protected $createdFilesList;
    protected $searchArray = [];
    protected $replaceArray = [];

    public function __construct(array $applicationDataForUser)
    {
        parent::__construct($applicationDataForUser);
        $event_dir_name = $this->applicationDataForUser[0]->event_dir_name;
        $templatesDirectory = "events/{$event_dir_name}/applications/{$this->submit->application_id}/templates";
        $this->submitAdditionalData = $this->getSubmitAdditionalData(['created_docs' => []]);
        $this->submitAdditionalData->created_docs = $this->submitAdditionalData->created_docs ?? [];


        $this->resultsDirectory = "events/{$event_dir_name}/applications/{$this->submit->application_id}/users_data/{$this->submit->user_id}/created_files";
        $this->resultsDirectoryFullPath = public_path() . "/storage/events/{$event_dir_name}/applications/{$this->submit->application_id}/users_data/{$this->submit->user_id}/created_files";
        $this->templateFilesList = Storage::files($templatesDirectory);
        $this->getReplaceAndSearchData();
        $this->templatesDataGenerator = $this->readTemplates();
        Storage::makeDirectory($this->resultsDirectory);
    }

    public function createDocs(): array
    {
        foreach ($this->templatesDataGenerator as $templateName => $templateData) {

            $content = str_replace($this->searchArray, $this->replaceArray, $templateData);

            Storage::put(
                $this->resultsDirectory . '/' . $templateName,
                $content
            );
            self::createPDF($this->resultsDirectoryFullPath, $templateName);

            $this->createdFilesList[] = $this->resultsDirectory . '/' . basename($templateName, ".rtf") . ".pdf";
        }

        $this->submitAdditionalData->created_docs = $this->createdFilesList;
        $this->submit->update(['additional_data' => json_encode($this->submitAdditionalData)]);
        return $this->createdFilesList;
    }

    public static function createPDF($resultsDirectoryFullPath, $templateName): void
    {
        exec("/usr/bin/libreoffice6.3 --headless --invisible --norestore --convert-to pdf " . $resultsDirectoryFullPath . '/' . $templateName . ' --outdir ' . $resultsDirectoryFullPath);
    }

    protected function translit($str)
    {
        $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
        $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Zh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'zh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
        return str_replace($rus, $lat, $str);
    }

    public function readTemplates()
    {
        foreach ($this->templateFilesList as $file) {
            yield basename($file) => Storage::get($file);
        }
    }

    public function getReplaceAndSearchData(): void
    {
        $tab = array("\r");
        $par = "\par";

        foreach ($this->applicationDataForUser as $value) {
            $this->searchArray[] = $value->name;
            $this->replaceArray[] = mb_convert_encoding(str_replace($tab, $par, $value->answer), 'Windows-1251', 'utf-8');
        }
    }
}
