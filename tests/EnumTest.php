<?php
namespace tests;

use tests\dummy\Status;

class EnumTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $this->assertEquals(new Status(Status::DISABLED), Status::DISABLED());
        $this->assertEquals(new Status(Status::VISIBLE), Status::VISIBLE());
        $this->assertEquals(new Status(Status::INVISIBLE), Status::INVISIBLE());
        $this->assertEquals(new Status(Status::OTHER), Status::OTHER());
    }

    public function testById()
    {
        $this->assertEquals(new Status(Status::DISABLED), Status::byId(Status::DISABLED));
        $this->assertEquals(new Status(Status::VISIBLE), Status::byId(Status::VISIBLE));
        $this->assertEquals(new Status(Status::INVISIBLE), Status::byId(Status::INVISIBLE));
        $this->assertEquals(new Status(Status::OTHER), Status::byId(Status::OTHER));
    }

    public function testGetter()
    {
        $disabled = Status::DISABLED();

        $this->assertEquals(0, $disabled->id);
        $this->assertEquals('使用不可', $disabled->name);
        $this->assertEquals(null, $disabled->visibility);
        $this->assertEquals('IDは0っぽい', $disabled->comment);

        $visible = Status::VISIBLE();

        $this->assertEquals(1, $visible->id);
        $this->assertEquals('可視', $visible->name);
        $this->assertEquals(true, $visible->visibility);
        $this->assertEquals('IDは1っぽい', $visible->comment);

        $invisible = Status::INVISIBLE();

        $this->assertEquals(2, $invisible->id);
        $this->assertEquals('不可視', $invisible->name);
        $this->assertEquals(false, $invisible->visibility);
        $this->assertEquals('IDは2っぽい', $invisible->comment);

        $other = Status::OTHER();

        $this->assertEquals(9, $other->id);
        $this->assertEquals('その他', $other->name);
        $this->assertEquals(true, $other->visibility);
        $this->assertEquals('IDは9っぽい', $other->comment);
    }

    public function testAll()
    {
        $this->assertContainsOnlyInstancesOf(Status::class, Status::all());
    }

    public function testAllWithArgument()
    {
        $this->assertEquals([
            Status::DISABLED    => Status::DISABLED,
            Status::VISIBLE     => Status::VISIBLE,
            Status::INVISIBLE   => Status::INVISIBLE,
            Status::OTHER       => Status::OTHER,
        ], Status::all('id'));

        $this->assertEquals([
            Status::DISABLED    => '使用不可',
            Status::VISIBLE     => '可視',
            Status::INVISIBLE   => '不可視',
            Status::OTHER       => 'その他',
        ], Status::all('name'));

        $this->assertEquals([
            Status::DISABLED    => null,
            Status::VISIBLE     => true,
            Status::INVISIBLE   => false,
            Status::OTHER       => true,
        ], Status::all('visibility'));

        $this->assertEquals([
            Status::DISABLED    => 'IDは0っぽい',
            Status::VISIBLE     => 'IDは1っぽい',
            Status::INVISIBLE   => 'IDは2っぽい',
            Status::OTHER       => 'IDは9っぽい',
        ], Status::all('comment'));
    }

    public function testIsset()
    {
        $status = Status::DISABLED();
        $this->assertTrue(isset($status->id));
        $this->assertTrue(isset($status->name));
        $this->assertFalse(isset($status->visibility));
        $this->assertFalse(isset($status->hoge));
    }
}
