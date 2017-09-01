<?php
namespace Aizuyan\Memo;

use Symfony\Component\Finder\Finder;

class Memo
{
    protected static $dataPath = "%s/.memo";

    protected static $nowMemo = "%s/head_memo_name_record";

    protected static $defaultMemoName = "默认备忘录";
    protected static $memoPath = "%s/%s";

    public static function initEnv()
    {
        $home = getenv("HOME");
        self::$dataPath = sprintf(self::$dataPath, $home);
        if (is_dir(self::$dataPath)) {
            return true;
        }
        if (!mkdir(self::$dataPath)) {
            echo "初始化失败，请确保[".self::$dataPath."]存在<br>";
            exit();
        } else {
            self::createMemo(self::$defaultMemoName);
            self::changeMemo(self::$defaultMemoName);
        }
    }

    public static function createMemo($name)
    {
        $memoPath = sprintf(self::$memoPath, self::$dataPath, $name);
        $flag = touch($memoPath);
        return $flag ? true : false;
    }

    public static function changeMemo($name)
    {
        $nowMemoPath = sprintf(self::$nowMemo, self::$dataPath);
        $flag = file_put_contents($nowMemoPath, $name);
        return $flag ? true : false;
    }

    public static function getNowMemoName()
    {
        $nowMemo = sprintf(self::$nowMemo, self::$dataPath);
        $record = trim(file_get_contents($nowMemo));   
        return $record;
    }

    public static function listAllMemo()
    {
        $finder = new Finder();
        $finder->files()->in(self::$dataPath);
        foreach ($finder as $file) {
            var_dump($file->getRelativePathname());
        }
    }
}
