[安装](../installation/introduction.md)完成之后，你离启动 HHVM 只有一步之遥。

通常情况下，你会有两种不同的运行 HHVM 的模式：

* [CLI（命令行）](./command-line.md) 模式，执行一些独立的脚本。 
* [server](./server.md) 模式，用 HHVM 来处理用户的 web 请求。

## 默认配置

HHVM 的默认配置分为 CLI 模式的 `php.ini`和 server 模式的 `server.ini`（在 Linux 环境下，这两个文件一般会在 `/etc/hhvm` 里）

默认配置已经可以满足大多数场景的需求了，所以一般来说你不需要去调整 INI 设置，当你启动 HHVM 的时候，相应的配置会自动加载进来。

当你对 HHVM 已经熟悉了或者你有特别的需求，你可以按照你的情况去调整[配置选项](../configuration/introduction.md)

---

> *本节由 [Y!an](https://yian.me/blog/) 翻译*