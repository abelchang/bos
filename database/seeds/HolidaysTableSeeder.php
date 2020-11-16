<?php

use App\Holidays;
use Illuminate\Database\Seeder;

class HolidaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // holidays [ [date],[name] => [isHoliday] => 是 [holidayCategory] => 星期六、星期日 [description]]
        // DB::table('holidays')->delete();
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'https://data.ntpc.gov.tw/api/datasets/308DCD75-6434-45BC-A95F-584DA4FED251/xml?page=0&size=50');
        $resBody = $res->getBody();
        $xml = simplexml_load_string($resBody, 'SimpleXMLElement', LIBXML_NOCDATA);
        $holidays = json_decode(json_encode($xml), true);
        $holidays = json_decode(json_encode($holidays['row']));
        // holidays [ [date],[name] => [isHoliday] => 是 [holidayCategory] => 星期六、星期日 [description]]
        foreach ($holidays as $key => $value) {
            foreach ($value as $index => $v) {
                if (is_object($v)) {
                    $holidays[$key]->$index = null;
                } elseif ($v == "是") {
                    $holidays[$key]->$index = true;
                } elseif ($v == "否") {
                    $holidays[$key]->$index = false;
                }
            }
        }
        foreach ($holidays as $obj) {
            Holidays::create(array(
                'date' => $obj->Col1,
                'name' => $obj->Col2,
                'isHoliday' => $obj->Col3,
                'holidayCategory' => $obj->Col4,
                'description' => $obj->Col5,
            ));
        }
    }
}
