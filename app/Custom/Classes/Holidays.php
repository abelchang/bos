<?php
namespace App\Custom\Classes;

class Holidays
{

    public function getHolidaysSource()
    {

        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'https://data.ntpc.gov.tw/api/datasets/308DCD75-6434-45BC-A95F-584DA4FED251/xml?page=0&size=50000');
        $resBody = $res->getBody();
        $xml = simplexml_load_string($resBody, 'SimpleXMLElement', LIBXML_NOCDATA);
        $holidays = json_decode(json_encode($xml), true);
        $holidays = json_decode(json_encode($holidays['row']));
        // holidays [ [date],[name] => [isHoliday] => 是 [holidayCategory] => 星期六、星期日 [description]]
        foreach ($holidays as $key => $value) {
            foreach ($value as $index => $v) {
                if (is_array($v)) {
                    $holidays[$key]->$index = implode(" ", $v);
                } elseif ($v == "是") {
                    $holidays[$key]->$index = true;
                } elseif ($v == "否") {
                    $holidays[$key]->$index = false;
                }
            }
        }
        return $holidays;
    }
}
