server 模式是给你提供 web 请求处理的一种方式，HHVM 进程启动之后会持续地监听并处理 web 请求。

当然了，HHVM 是可以同时处理并发请求的，并且 HHVM 会缓存你的代码，不同的请求都可以共享到这个缓存。

下面是启动 HHVM server 模式最简单的例子。

```
% hhvm -m server -p 8080
```

`-m` 是 `模式` 选项，默认是 [命令行模式](./command-line.md)。

`-p` 是 HHVM 监听的端口，默认是 80。

你执行 `hhvm` 命令的目录将会作为你代码文件的根目录。

## 自定义配置

`-d` 可以覆盖命令行[配置](../configuration/introduction.md)中的选项

在上面的例子中，默认使用的是 HHVM 内置的 [proxygen](./proxygen.md) 作为 web server 来监听 8080 端口。

我们可以删除 `-p 8080` 并显式追加下面的内容到上面的命令：

`-d hhvm.server.type=proxygen -d hhvm.server.port=8080 -d hhvm.server.source_root=./`

尽管将命令写这么详细实现的目的跟之前一样，但这么做也可能有一定的道理（译者注：比如 ini 里的默认配置被修改过了，你就需要显式指定相应的参数）。除此之外，你也可以用 -d 来自定义其他各种[设置](../configuration/introduction.md)。

HHVM 也会继续使用 `server.ini` （大多数 Linux 环境中在 `/etc/hhvm/`，macOS 中在 `/usr/local/etc/hhvm/`）中默认的配置。

## 客户端访问 server 模式下的 HHVM

通常情况下，一个 web 请求是长下面这样的：

```
http://your.site:8080/index.php
```

你可以用 `curl` 或者其他程序来访问 HHVM 服务端。

### Possible Fatal Error

如果你运行的是 [Hack (<?hh>)](/hack/) 代码，并且你得到了一个 [由于没有运行类型检查器导致的致命错误](/hhvm/FAQ/faq#running-code__how-do-i-fix-the-not-running-the-hack-typechecker-fatal-error)，那你需要做以下的任一操作：

- 创建一个名为 `.hhconfig` 的空文件在你的代码根目录中
- 在 `hhvm -m server...` 命令后面加上 `-d hhvm.hack.lang.look_for_typechecker=0`

---

> *本节由 [Y!an](https://yian.me/blog/) 翻译*