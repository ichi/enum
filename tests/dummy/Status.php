<?php
namespace tests\dummy;

use Ichi\Enum\Enum;

class Status extends Enum
{
     const DISABLED  = 0;
     const VISIBLE   = 1;
     const INVISIBLE = 2;
     const OTHER     = 9;

     protected static $contents = [
         self::DISABLED  => ['name' => '使用不可'],
         self::VISIBLE   => ['name' => '可視',   'visibility' => true],
         self::INVISIBLE => ['name' => '不可視', 'visibility' => false],
         self::OTHER     => ['name' => 'その他', 'visibility' => true],
     ];

     public function comment(){
         return 'IDは' . $this->id . 'っぽい';
     }
}
