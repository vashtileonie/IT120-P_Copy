<?php

namespace App\Traits;

use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Writer\XLSX\Options;
use OpenSpout\Common\Entity\Style\CellAlignment;
use Spatie\SimpleExcel\SimpleExcelWriter;

trait ExportSimpleExcelTrait
{
    public function createReport($filename, bool $is_csv = false){
        logger("Export started for ".$filename);
        if ($is_csv) {
            $this->createCsvReport($filename);
            return;
        }

        try{
            $newoptions = new Options();
            $simplewriter =
                SimpleExcelWriter::create($filename, ''
                    ,function ($writer) use( &$newoptions) {
                        $newoptions = $writer->getOptions();
                    });

            logger("File ".$filename ." created");
                    
            $newoptions->setColumnWidth(30, 2, 6);
            $newoptions->setColumnWidth(20, 3, 4);

            $this->writeHeader($simplewriter,  $newoptions);
            $this->writeData($simplewriter);

        } catch(\Exception $e){
            logError('[createReport] exception='. $e->getMessage());
        }
    }


    public function createCsvReport($filename)
    {
        $export_on_fly = config('admin.export_on_fly');
        if ($export_on_fly) {
            header("Content-type: text/csv");
            header("Content-Disposition: attachment; filename=$filename");
            header("Pragma: no-cache");
            header("Expires: 0");

            $output = fopen('php://output', 'w');

        } else {
            $output = fopen($filename, "w");
        }

        fputcsv($output, $this->getHeader());

        $query = $this->getQuery();

        $chunks = $query->get()->chunk((int) config('admin.export_chunk_size'));
        foreach ($chunks as $chunk) {
            $chunk = json_decode(json_encode($chunk,true),true);
            foreach ($chunk as $data) {
                fputcsv($output, $data);
            }

            flush();
        }
        
        fclose($output);

        if ($export_on_fly) {
            exit;
        }
     }


    protected function writeData(&$simplewriter){
        $query = $this->getQuery();

        $chunks = $query->get()->chunk((int) config('admin.export_chunk_size'));
        foreach ($chunks as $chunk) {
            $simplewriter->addRows(json_decode(json_encode($chunk,true),true));
            flush();
        }
        
        $simplewriter->close();
    }


    private function formatRow($data, $fields, $dataFields, &$ctr)
    {
        $row = [];

        foreach($fields as $field => $val){
            $key = $val;
            if ($val === "#") {
                $row[$val] = $ctr++;
                continue;
            }

            if (! is_numeric($field)) {
                $row[$field] = $data->{$field}?->$val ?? '';
                $key = $field;
            } else {
                $row[$val] = $data->{$val} ?? '';
            }

            //formate date
            if (! empty($dataFields) && in_array($key, $dataFields) !== false) {
                $row[$key] =  date('M d, Y h:i A', strtotime($row[$key]));
            }
        }

        return $row;
    }


    protected function getDateFields()
    {
        return $this->dateFields;
    }


    public function getFields()
    {
        return $this->fields;
    }


    public function getHeader()
    {
        return $this->header;
    }


    public function getTitle()
    {
        return $this->title;
    }


    public function getQuery()
    {
        return $this->query;
    }


    private function writeHeader(&$simplewriter, &$newoptions)
    {
        $newoptions->mergeCells(count($this->getHeader())-1, 1, 0, 2, 0);
        $header_style = (new Style())->setFontBold()->setFontSize(20)->setCellAlignment(CellAlignment::CENTER);
        $simplewriter->setHeaderStyle($header_style);

        if (empty(!$title = $this->getTitle())) {
            $simplewriter->addHeader([$title]);
            $simplewriter->addHeader([]);
        }

        $header_style = (new Style())->setFontBold();
        $simplewriter->setHeaderStyle($header_style);
        $simplewriter->addHeader($this->getHeader());
    }
}
