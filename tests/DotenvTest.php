<?php

namespace Test\DevCoder;

use DevCoder\DotEnv;
use DevCoder\Option;
use PHPUnit\Framework\TestCase;

class DotenvTest extends TestCase
{
    private function env(string $file)
    {
        return __DIR__ . DIRECTORY_SEPARATOR . 'env' . DIRECTORY_SEPARATOR . $file;
    }

    /**
     * @runInSeparateProcess
     */
    public function testLoad() {
        (new DotEnv($this->env('.env.default')))->load();
        $this->assertEquals('dev', getenv('APP_ENV'));
        $this->assertEquals('mysql:host=localhost;dbname=test;', getenv('DATABASE_DNS'));
        $this->assertEquals('root', getenv('DATABASE_USER'));
        $this->assertEquals('password', getenv('DATABASE_PASSWORD'));
        $this->assertFalse(getenv('GOOGLE_API'));
        $this->assertFalse(getenv('GOOGLE_MANAGER_KEY'));

        $this->assertEquals('dev', $_ENV['APP_ENV']);
        $this->assertEquals('mysql:host=localhost;dbname=test;', $_ENV['DATABASE_DNS']);
        $this->assertEquals('root', $_ENV['DATABASE_USER']);
        $this->assertEquals('password', $_ENV['DATABASE_PASSWORD']);
        $this->assertFalse(array_key_exists('GOOGLE_API', $_ENV));
        $this->assertFalse(array_key_exists('GOOGLE_MANAGER_KEY', $_ENV));

        $this->assertEquals('dev', $_SERVER['APP_ENV']);
        $this->assertEquals('mysql:host=localhost;dbname=test;', $_SERVER['DATABASE_DNS']);
        $this->assertEquals('root', $_SERVER['DATABASE_USER']);
        $this->assertEquals('password', $_SERVER['DATABASE_PASSWORD']);
        $this->assertFalse(array_key_exists('GOOGLE_API', $_SERVER));
        $this->assertFalse(array_key_exists('GOOGLE_MANAGER_KEY', $_SERVER));
    }

    public function testFileNotExist() {
        $this->expectException(\InvalidArgumentException::class);
        (new DotEnv($this->env('.env.not-exists')))->load();
    }

    /**
     * @runInSeparateProcess
     */
    public function testProcessBoolean()
    {
        (new DotEnv($this->env('.env.boolean'), [
            Option::PROCESS_BOOLEANS => true
        ]))->load();

        $this->assertEquals(false, $_ENV['FALSE1']);
        $this->assertEquals(false, $_ENV['FALSE2']);
        $this->assertEquals(false, $_ENV['FALSE3']);
        $this->assertEquals(false, $_ENV['FALSE4']);
        $this->assertEquals('0', $_ENV['FALSE5']);

        $this->assertEquals(true, $_ENV['TRUE1']);
        $this->assertEquals(true, $_ENV['TRUE2']);
        $this->assertEquals(true, $_ENV['TRUE3']);
        $this->assertEquals(true, $_ENV['TRUE4']);
        $this->assertEquals('1', $_ENV['TRUE5']);
    }

    /**
     * @runInSeparateProcess
     */
    public function testDontProcessBoolean()
    {
        (new DotEnv($this->env('.env.boolean'), [
            Option::PROCESS_BOOLEANS => false
        ]))->load();

        $this->assertEquals('false', $_ENV['FALSE1']);

        $this->assertEquals('true', $_ENV['TRUE1']);
    }

    /**
     * @runInSeparateProcess
     */
    public function testProcessQuotes()
    {
        (new DotEnv($this->env('.env.quotes'), [
            Option::PROCESS_QUOTES => true
        ]))->load();

        $this->assertEquals('q1', $_ENV['QUOTED1']);
        $this->assertEquals('q2', $_ENV['QUOTED2']);
        $this->assertEquals('"q3"', $_ENV['QUOTED3']);
        $this->assertEquals('This is a "sample" value', $_ENV['QUOTED4']);
        $this->assertEquals('\"This is a "sample" value\"', $_ENV['QUOTED5']);
        $this->assertEquals('"q6', $_ENV['QUOTED6']);
        $this->assertEquals('q7"', $_ENV['QUOTED7']);
    }

    /**
     * @runInSeparateProcess
     */
    public function testDontProcessQuotes()
    {
        (new DotEnv($this->env('.env.quotes'), [
            Option::PROCESS_QUOTES => false
        ]))->load();

        $this->assertEquals('"q1"', $_ENV['QUOTED1']);
        $this->assertEquals('\'q2\'', $_ENV['QUOTED2']);
        $this->assertEquals('""q3""', $_ENV['QUOTED3']);
        $this->assertEquals('"This is a "sample" value"', $_ENV['QUOTED4']);
        $this->assertEquals('\"This is a "sample" value\"', $_ENV['QUOTED5']);
        $this->assertEquals('"q6', $_ENV['QUOTED6']);
        $this->assertEquals('q7"', $_ENV['QUOTED7']);
    }
}
