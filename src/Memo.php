<?php
namespace Aizuyan\Memo;

use Symfony\Component\Finder\Finder;
use Aizuyan\Memo\Exception\MemoException;

class Memo
{
    /**
     * @var 操作系统类型，未知、windows、linux
     */
    const OS_NONE = 0;
    const OS_WIN = 1;
    const OS_LINUX = 2;

    /**
     * 备忘录数据根目录
     * @var string
     */
    protected static $dataPath = "";

    /**
     * 备忘录具体信息保存的目录
     * @var string
     */
    protected static $memoPath = "";

    /**
     * 记录当前备忘录名称的文件
     * @var string
     */
    protected static $currentMemoRecordFile = "";

    /**
     * 是否初始化过得文件标志，存在：已经初始化，不存在：未初始化
     * @var string
     */
    protected static $initFlagFile = "";

    /**
     * 获取当前用户操作系统类型
     * @return int 当前用户操作系统类型
     */
    public static function getOsType()
    {
        $os = self::OS_NONE;
        if (DIRECTORY_SEPARATOR == "\\") {
            $os = self::OS_WIN;
        } else if (DIRECTORY_SEPARATOR == "/") {
            $os = self::OS_LINUX;
        }

        return $os;
    }

    /**
     * 获取当前用户家目录
     * @return string
     */
    public static function getUserDir()
    {
        $os = self::getOsType();

        $home = "";
        if (self::OS_WIN == $os) {
            $home = getenv("USERPROFILE");
        } else if (self::OS_LINUX == $os) {
            $home = getenv("HOME");
        }

        return $home;
    }

    protected function initPathVar()
    {
        $home = self::getUserDir();
        self::$dataPath = sprintf("%s/.memo", $home);
        self::$memoPath = sprintf("%s/memo", self::$dataPath);
        self::$initFlagFile = self::$dataPath . "/initFlag";
        self::$currentMemoRecordFile = sprintf("%s/head_memo_name_record", self::$dataPath);
    }

    /**
     * 判断是否初始化过
     * @return boolean true/false 已经初始化过/为初始化过
     */
    public static function isInit()
    {
        clearstatcache();
        $flag = file_exists(self::$initFlagFile);

        return $flag ? true : false;
    }

    public static function init()
    {
        if (self::isInit()) {
            throw new MemoException("已经初始化过了", 1);
        }
        $flag = mkdir(self::$dataPath) && mkdir(self::$memoPath) && touch(self::$initFlagFile);
        if (!$flag) {
            throw new MemoException("舒适化失败", 1);
        }
        $defaultMemo = "默认备忘录";
        // 创建默认备忘录
        self::createMemo($defaultMemo);
        // 切换当前备忘录为默认备忘录
        self::changeMemo($defaultMemo);
    }

    public static function createMemo($name)
    {
        $memoPath = self::$memoPath . "/{$name}";
        $flag = touch($memoPath);
        return $flag ? true : false;
    }

    public static function changeMemo($name)
    {
        $flag = file_put_contents(self::$currentMemoRecordFile, $name);
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
        $record = trim(file_get_contents(self::$currentMemoRecordFile));   
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

    public static function addMemo($memo)
    {
        $memoName = self::getNowMemoName();
        $memoPath = self::$memoPath . "/" . $memoName;
        $lists = file_get_contents($memoPath);
        $lists = json_decode($lists, true);
        $lists = empty($lists) ? [] : $lists;
        $shortName = self::getMemoShortName($memo);
        $lists[$shortName] = [
            "memo" => $memo,
            "status" => "init",
        ];
        $flag = file_put_contents($memoPath, json_encode($lists));
        return $flag ? true : false;
    }

    public static function showMemo()
    {
        $memoName = self::getNowMemoName();
        $memoPath = self::$memoPath . "/" . $memoName;
        $lists = file_get_contents($memoPath);
        $lists = json_decode($lists, true);
        $lists = empty($lists) ? [] : $lists;
        return $lists;
    }

    public static function doMemo($shortName, &$fullName)
    {
        $memoName = self::getNowMemoName();
        $memoPath = self::$memoPath . "/" . $memoName;
        $lists = file_get_contents($memoPath);
        $lists = json_decode($lists, true);
        $lists = empty($lists) ? [] : $lists;
        if (!isset($lists[$shortName])) {
            return false;
        }
        $lists[$shortName]["status"] = "done";
        $fullName = $lists[$shortName]["memo"];
        $flag = file_put_contents($memoPath, json_encode($lists));
        return $flag ? true : false;
    }
}
