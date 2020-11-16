<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Holidays extends Model
{
    // holidays [ [date],[name] => [isHoliday] => 是 [holidayCategory] => 星期六、星期日 [description]]
    protected $table = 'holidays';

    protected $fillable = ['date', 'name', 'isHoliday', 'holidayCategory', 'description'];

    public static function isHolidayFunc($date)
    {
        return DB::table('holidays')->where('date', $date)->value('isHoliday');
    }

}
