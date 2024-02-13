<?php

class CSV
{
    private $_csv_file = 'result.csv';

    public function __construct()
    {
        $fp = fopen($this->_csv_file, "w");
        fclose($fp);
    }


    public function set(array $csv)
    {

        $handle = fopen($this->_csv_file, "a");

        foreach ($csv as $value) {
            fputcsv($handle, explode(";", $this->toWindow($value)), ";");
        }
        fclose($handle);
    }


    public function get()
    {
        $handle = fopen($this->_csv_file, "r");

        $array_line_full = array();
        while (($line = fgetcsv($handle, 0, ";")) !== FALSE) {
            $array_line_full[] = $line;
        }
        fclose($handle);
        return $array_line_full;
    }



    function toWindow(string $string)
    {
        return iconv("utf-8", "windows-1251", $string);
    }
}

try {
    $csv = new CSV();

    $file_name_1 = '1.txt';
    $file_name_2 = '2.txt';
    $file_name_3 = '3.txt';
    $is_files_end = false;

    $fs1 = fopen($file_name_1, 'r');
    $fs2 = fopen($file_name_2, 'r');
    $fs3 = fopen($file_name_3, 'r');

    while ($is_files_end !== true) {
        $file_1 = fgets($fs1);
        $file_2 = fgets($fs2);
        $file_3 = fgets($fs3);

        $csv->set([
            implode(
                ';',
                [
                    str_replace(array("\r\n", "\r", "\n"), ' ',  $file_1),
                    str_replace(array("\r\n", "\r", "\n"), ' ',  $file_2),
                    str_replace(array("\r\n", "\r", "\n"), ' ',  $file_3)
                ]
            )
        ]);


        $is_files_end = !((bool)$file_1 && (bool)$file_2 && (bool) $file_3);
    }

    fclose($fs1);
    fclose($fs2);
    fclose($fs3);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
