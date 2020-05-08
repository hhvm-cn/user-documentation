如果你之前没有接触过 HHVM，这个快速指南可以让你快速上手，当然了，作为快速指南，说明这里不会展开太多复杂的细节，如果你需要查看完整的文档，请点击[这里](..)

## 概览

用 HHVM 来运行你的代码是非常简单的，你只需要准备：

* HHVM 本身
* Hack 代码

在安装的时候，虽然不同版本的 Debian 和 Ubuntu 你都能获取到[官方编译的 HHVM](../installation/introduction.md#prebuilt-packages)，但还是建议你在最新的 Ubuntu LTS 上安装以获得最佳安装体验。

## 安装 HHVM

请参阅[我们关于安装预编译包的说明](../installation/introduction.md#prebuilt-packages).

你也可以选择[采用源码编译 HHVM](../installation/building-from-source.md)，不过会比较复杂且费时，因此，除非你已经熟悉 HHVM 了且你有特殊的需求，否则我们不推荐你采用源码编译的方式来装

## 测试 HHVM

安装完 HHVM 之后，切换到你项目的代码目录，然后启动 HHVM：

```
hhvm -m server -p 8080
```

`-m` 表示[工作模式](../basic-usage/introduction.md)，这里我们指定 HHVM 以 HTTP server 的模式来启动

`-p` 指定 HHVM 在 HTTP 模式下监听的 TCP 请求端口，默认是标准 HTTP 端口 80，不过由于 80 端口需要有管理员权限才能监听，因此在这个例子中，我们监听 8080 端口

当你的 HHVM 启动起来之后，咱们来写下第一个 "Hello World" 程序，命名为 `hello.hack`：

```
<<__EntryPoint>>
function main(): void {
  echo "Hello World!\n";
}
```

保存 `hello.hack` 到刚刚执行 `hhvm` 命令的工作目录，然后用浏览器访问 [http://localhost:8080/hello.hack](http://localhost:8080/hello.hack) ，你就可以看到 “Hello World!” 了

## 配置 HHVM

HHVM 的配置是开箱即用的，一般来说你不需要去修改它的配置。需要注意的是，给 HHVM 加速的 JIT 编译器默认是开启的。如果你想查看已有配置，Linux 请查看 `/etc/hhvm/php.ini`，macOS 请查看 `/usr/local/etc/hhvm/php.ini`

当你将 HHVM 设置为开机自启的服务而不是像上面这样通过终端模拟器启动时，你就需要专门做一些配置了，具体请查看[proxygen 文档](../basic-usage/proxygen)

## 运行 Hack 代码文件

[Hack](/hack/getting-started/getting-started) 是 Facebook 发明的一门编程语言，它基于 PHP 的语法，提供了类型检查等[众多语言特性](/hack/)，HHVM 是可以运行 Hack 代码的，比如说上面用来测试 HHVM 的 Hello world 程序

在测试和执行 Hack 文件之前，确保你已经用 `hh_client` 检查过你的代码文件了，否则你将可能会得到一堆类型错误提示

## 学习 Hack 和 PHP

学习 PHP 和 Hack 编程语言超出了本指南的范围，如果你想认真地学习，那么最佳的资料就是[官方 Hack 文档](/hack/getting-started/getting-started)，还有非常推荐一本由 Facebook HHVM 团队的工程师编写的书[《O'Reilly book on HHVM and Hack》](http://www.amazon.com/Hack-HHVM-Programming-Productivity-Breaking/dp/1491920874/)

关于 PHP 的资料，请查阅[PHP 官方文档](http://docs.php.net/manual/zh/getting-started.php)，上面有很详尽的关于 PHP 的介绍以及大量代码示例

---

> *本节由 [Y!an](https://yian.me/blog/) 翻译*