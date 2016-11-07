# Enum

参考: [PHPで列挙型(enum)を作る by @Hiraku on @Qiita](http://qiita.com/Hiraku/items/71e385b56dcaa37629fe)

## USAGE

### 定義例

```php
<?php
namespace App\Enum;

class Status extends \Ichi\Enum\Enum{
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
```

### 使用例（個別）

```php
<?php
$enum = App\Enum\Status::VISIBLE(); // `new App\Enum\Status(App\Enum\Status::VISIBLE)`と同じ
$enum->id;           // => 1
$enum->name;         // => '可視'
$enum->visiblity;    // => true
$enum->comment;      // => 'IDは1っぽい'

$enum = App\Enum\Status::DISABLED();
$enum->id;           // => 0
$enum->name;         // => '使用不可'
$enum->visiblity;    // => null // 未定義なものはnull
$enum->comment;      // => 'IDは0っぽい'
```

### 使用例（まとめて）

```php
<?php
App\Enum\Status::all();             // => [0 => App\Enum\Status::DISABLED(), 1 => App\Enum\Status::VISIBLE(), 2 => App\Enum\Status::INVISIBLE(), 9 => App\Enum\Status::OTHER()]
App\Enum\Status::all('name');       // => [0 => '使用不可', 1 => '可視', 2 => '不可視', 9 => 'その他']
App\Enum\Status::all('visibility'); // => [0 => null, 1 => true, 2 => false, 9 => true]
App\Enum\Status::all('comment');    // => [0 => 'IDは0っぽい', 1 => 'IDは1っぽい', 2 => 'IDは2っぽい', 9 => 'IDは9っぽい']
```
