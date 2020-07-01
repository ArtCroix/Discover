<?php

namespace App\Src\ApplicationHandlers\AfterSubmitHandlers;

use App\Src\ApplicationHandlers\FileHandler;
use Illuminate\Support\Facades\Storage;


trait  DocHandlerTrait
{
    protected $resultsDirectory;
    protected $resultsDirectoryFullPath;
    protected $templateFilesList;
    protected $templatesDataGenerator;
    protected $createdFilesList;
    protected $searchArray = [];
    protected $replaceArray = [];


    public function createDocs(): array
    {
        foreach ($this->templatesDataGenerator as $templateName => $templateData) {

            $content = strtr($templateData, $this->replaceArray);

            Storage::put(
                $this->resultsDirectory . '/' . $templateName,
                $content
            );
            self::createPDF($this->resultsDirectoryFullPath, $templateName);

            $this->createdFilesList[] = $this->resultsDirectory . '/' . basename($templateName, ".rtf") . ".pdf";
        }

        $this->submitAdditionalData->created_docs = $this->createdFilesList;
        $this->submit->update(['additional_data' => json_encode($this->submitAdditionalData)]);
        FileHandler::archiveFiles($this->resultsDirectory);
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
            if ($value->name) {
                $this->replaceArray[$value->name] = mb_convert_encoding(str_replace($tab, $par, $value->answer), 'Windows-1251', 'utf-8');
            }
        }
    }
}
