一般情况下，在安装 HHVM 后，可以使用官方提供的[合理默认值](../basic-usage/introduction.md)来[运行 Hack 和 PHP 脚本](../basic-usage/command-line.md)，或者[将 HHVM 作为服务来运行](../basic-usage/server.md)。

虽然大多数时候不需要调整默认配置或使用 HHVM 提供的更高级模式，但你也可以这样做：

* [仓库授权](./repo-authoritative.md) 模式可以将整个代码库编译成一个单元，允许 HHVM 执行极致的优化，让代码快速运行。

* [守护进程](./daemon.md) 模式允许将 HHVM 作为后台进程运行。
* [管理服务器](./admin-server.md) 允许你监控 HHVM，因为它是在服务器模式下运行的。

* [FastCGI](/hhvm/advanced-usage/fastCGI) 是 HHVM 的另一种服务器类型，它的可配置性强，速度快，但需要在它的基础上再加一个独立的 web服务器。

## 自定义配置

除此之外，还有大量的[自定义配置选项](../configuration/introduction.md)，你可以设置来调整 HHVM 在运行脚本或作为服务运行时的运作方式。

---

> *本节由 [Evilran](https://github.com/Evilran) 翻译*