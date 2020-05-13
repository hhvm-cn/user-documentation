在 CLI 模式下，你将从“命令行”启动 HHVM 来执行你的脚本，当你的脚本运行完之后，HHVM 会立即退出。

下面是一个从命令行启动 HHVM 来执行 PHP 文件的例子：

@@ command-line-examples/fib.php @@

在命令行中，执行如下命令：

```
% hhvm /path/to/fib.php 10
```

你需要给出 `hhvm` 可执行程序、`fib.php` 的路径，以及 `fib.php` 接收的参数（当然，不是所有脚本都需要给定参数的）。

然后你就可以看到如下输出：

```
The 10 number in fibonacci is: 55
```

---

> *本节由 [Y!an](https://yian.me/blog/) 翻译*