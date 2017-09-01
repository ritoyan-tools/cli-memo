<?php
namespace Aizuyan\Memo;

use Symfony\Component\Finder\Finder;

class Memo
{
    protected static $dataPath = "%s/.memo";
    protected static $memoPath = "%s/memo";

    const NOW_MEMO_NAME = "head_memo_name_record";

    const DEFAULT_MEMO_NAME = "默认备忘录";

    public static function initEnv()
    {
        $home = getenv("HOME");
        self::$dataPath = sprintf(self::$dataPath, $home);
        self::$memoPath = sprintf(self::$memoPath, self::$dataPath);
        if (is_dir(self::$dataPath) && is_dir(self::$memoPath)) {
            return true;
        }
        $flag = is_dir(self::$dataPath) || mkdir(self::$dataPath);
        $flag = $flag && (is_dir(self::$memoPath) || mkdir(self::$memoPath));
        if (!$flag) {
            echo "初始化失败，请确保[".self::$dataPath."],[".self::$memoPath."]存在<br>";
            exit();
        } else {
            self::createMemo(self::DEFAULT_MEMO_NAME);
            self::changeMemo(self::DEFAULT_MEMO_NAME);
        }
    }

    public static function createMemo($name)
    {
        $memoPath = self::$memoPath . "/{$name}";
        $flag = touch($memoPath);
        return $flag ? true : false;
    }

    public static function changeMemo($name)
    {
        $nowMemo = self::$dataPath."/".self::NOW_MEMO_NAME;
        $flag = file_put_contents($nowMemo, $name);
        return $flag ? true : false;
    }

    public static function delMemo($name)
    {
        $memo = self::$memoPath."/".$name;
        $flag = unlink($memo);
        return $flag ? true : false;
    }

    public static function getNowMemoName()
    {
        $nowMemo = self::$dataPath."/".self::NOW_MEMO_NAME;
        $record = trim(file_get_contents($nowMemo));   
        return $record;
    }

    public static function listAllMemo()
    {
        $finder = new Finder();
        $finder->files()->in(self::$memoPath);
        $memos = [];
        foreach ($finder as $file) {
            $memos[] = $file->getRelativePathname();
        }
        return $memos;
    }

    public static function getMemoShortName($name)
    {
        $md5 = md5($name);
        return substr($md5, 0, 8);
    }
}
