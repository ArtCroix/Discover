<?php

namespace App\Src\ApplicationHandlers;

use App\Application\Submit;
use Illuminate\Support\Facades\Storage;

class DocHandler
{

    protected $applicationDataForUser;
    protected $application_id;
    protected $event_dir_name;
    protected $user_id;
    protected $submit_id;
    protected $templatesDirectory;
    protected $resultsDirectory;
    protected $resultsDirectoryFullPath;
    protected $templateFilesList;
    protected $templatesDataGenerator;
    protected $createdFilesList;

    public function __construct(array $applicationDataForUser)
    {
        $this->applicationDataForUser = $applicationDataForUser;
        $this->application_id = $this->applicationDataForUser[0]->application_id;
        $this->event_dir_name = $this->applicationDataForUser[0]->event_dir_name;
        $this->user_id = $this->applicationDataForUser[0]->user_id;
        $this->submit_id = $this->applicationDataForUser[0]->submit_id;
        $this->templatesDirectory = "events/{$this->event_dir_name}/applications/{$this->application_id}/templates";
        $this->resultsDirectory = "events/{$this->event_dir_name}/applications/{$this->application_id}/users_data/{$this->user_id}/created_files";
        $this->resultsDirectoryFullPath = public_path() . "/storage/events/{$this->event_dir_name}/applications/{$this->application_id}/users_data/{$this->user_id}/created_files";
        $this->templateFilesList = Storage::files($this->templatesDirectory);
        $this->getReplaceAndSearchData();
        $this->templatesDataGenerator = $this->readTemplates();
        Storage::makeDirectory($this->resultsDirectory);
    }

    public function getDocsForApplication($application_id, $user_id)
    {
        Storage::files($this->templatesDirectory);
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
        Submit::find($this->submit_id)->update(['created_docs' => $this->createdFilesList]);
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
        foreach ($this->applicationDataForUser as $value) {
            $this->searchArray[] = $value->name;
            $this->replaceArray[] = $value->answer;
        }
    }
}
