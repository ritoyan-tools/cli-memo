### cli-memo
备忘录，命令行备忘录

#### 使用介绍
> 项目地址：[https://github.com/aizuyan/cli-memo](https://github.com/aizuyan/cli-memo)

这里面的所有备忘录、以及备忘录中的备忘都有一个短名称`shortName`，截取对应中文名
md5的前几位，以便于对其进行操作（比如，切换备忘录、删除备忘录、完成备忘等），避免
直接对冗长名称、数据操作，这也借鉴了git的提交版本。

##### 安装
这个可以通过`composer`安装在全局，再将`bin/`目录加入到`PATH`中，就可以直接使用了：

```sh
composer global require aizuyan/cli-memo
```
上面这个命令会包安装到` ~/.composer/`目录下面，再将`/Users/ruitao/.composer/vendor/bin`
路径配置到系统路径`PATH`中就可以直接使用`memo`命令了：

linux下面我是配置在`~/.bashrc`里面的：
`PATH=$PATH:/usr/local/bin:/Users/ruitao/.composer/vendor/bin`

##### memo help
`memo help`，这个命令展示了memo的所有命令列表：
```
➜  ~ memo help
  create    name                        创建新的备忘录
  change    short name                  切换备忘录
  del       short name                  删除备忘录

  add       memo string                 给当前的备忘录添加一条记录
  done      memo string short name      标记当前备忘录的某条备忘为已完成

  show                                  列出当前备忘录所有备忘
  list                                  列出所有的备忘录名称
```

##### memo init
`memo init`，这个命令用来初始化软件，包括在用户目录下新建必要的文件、文件夹，执行
成功之后，会在家目录下面创建如下的内容：
`/Users/ruitao/.memo/`是备忘录软件数据存放目录，`head_memo_name_record`用来记录
当前备忘录的名称，`initFlag`文件用来标记是否初始化过，`memo/`目录存放具体的备忘录
信息，每个备忘录一个文件。默认会创建一个`默认备忘录`，并将当前备忘录指向他。
```
/Users/ruitao/.memo/
├── head_memo_name_record
├── initFlag
└── memo/
    └── 默认备忘录
```

##### memo create
`memo create 工作备忘录`，这个命令用来创建备忘录，创建完成之后会在备忘录数据目录
创建`/Users/ruitao/.memo/memo/工作备忘录`文件

##### memo list
`memo list`，这个命令用来列出备忘录，如下面所示，小手指向的就是当前所在的备忘录，
另外备忘录前面有一串字母，这里是备忘录的标识，后面删除、切换备忘录的时候都要用到
他。
```
➜  cli-memo git:(master) bin/memo list
备忘录列表
  ☞  a69b36c0 默认备忘录
     8c13e2c7 工作备忘录
```

##### memo change
`memo change <shortName>`，这个命令用来切换当前的备忘录，跟git切换分支类似。就像
下面这样，切换之后，就会切换到备忘录[4be22fcf MCN备忘录]。
```
➜  ~ memo list
备忘录列表
  ☞  45e43b27 生活备忘录
     4be22fcf MCN备忘录
     8c13e2c7 工作备忘录
     a69b36c0 默认备忘录
➜  ~ memo change 4be22fcf
切换备忘录[4be22fcf => MCN备忘录]成功
➜  ~ memo list
备忘录列表
  ☞  4be22fcf MCN备忘录
     8c13e2c7 工作备忘录
     45e43b27 生活备忘录
     a69b36c0 默认备忘录
```

##### memo del
`memo del <shortName>`，这个命令用来删除不需要的备忘录，但是不能删除当前正在使用的分支
，就像下面这样：
```
➜  ~ memo list
备忘录列表
  ☞  45e43b27 生活备忘录
     4be22fcf MCN备忘录
     8c13e2c7 工作备忘录
     a69b36c0 默认备忘录
➜  ~ memo del a69b36c0
删除备忘录[a69b36c0 => 默认备忘录]成功
➜  ~ memo list
备忘录列表
  ☞  45e43b27 生活备忘录
     4be22fcf MCN备忘录
     8c13e2c7 工作备忘录
```

##### [memo show]|[memo]
`memo show`和命令`memo`是等价的，为了便于查看，默认命令设为`memo show`，如下所示：
其中分为两大类：待完成事项、已完成事项，待完成事项排列在前面，标记为已完成的事项
排列在后面。
```
➜  ~ memo show
生活备忘录
  待完成事项:
    ☞  5e23fd6d 每天坚持远眺
    ☞  7f3fc212 翻译文章《The Incredible Growth of Python》
  已完成事项:
    ✔  5a71bbc5 每天看书两个小时
➜  ~ memo
生活备忘录
  待完成事项:
    ☞  5e23fd6d 每天坚持远眺
    ☞  7f3fc212 翻译文章《The Incredible Growth of Python》
  已完成事项:
    ✔  5a71bbc5 每天看书两个小时
```

##### memo add
`memo add <string>`，在当前备忘录添加备忘记录，如下所示：
```
➜  ~ memo add 今天提测同步数据接口
添加备忘[今天提测同步数据接口]到备忘录[生活备忘录]成功
➜  ~ memo
生活备忘录
  待完成事项:
    ☞  5e23fd6d 每天坚持远眺
    ☞  7f3fc212 翻译文章《The Incredible Growth of Python》
    ☞  887bad83 今天提测同步数据接口
  已完成事项:
    ✔  5a71bbc5 每天看书两个小时
```

##### memo done
`memo done <shortName>`，在当前备忘录标记`shortName`对应的备忘记录为已完成，如下
所示：
```
➜  ~ memo done 887bad83
备忘[887bad83 => 今天提测同步数据接口]标记已完成成功
➜  ~ memo
生活备忘录
  待完成事项:
    ☞  5e23fd6d 每天坚持远眺
    ☞  7f3fc212 翻译文章《The Incredible Growth of Python》
  已完成事项:
    ✔  5a71bbc5 每天看书两个小时
    ✔  887bad83 今天提测同步数据接口
```

#### TODO
1. 因为短名称`shortName`使用的是md5的前几位，所以还是有一定几率重复的，这里需要解决下。
2. 添加时间概念，新建的时候添加什么时候提醒，发送邮件。
3. 解决win显示问题，没颜色可以显示整齐点儿
