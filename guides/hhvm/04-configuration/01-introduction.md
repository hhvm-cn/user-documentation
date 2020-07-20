[安装 HHVM](../installation/introduction.md) 后，你可能想配置它从命令行运行脚本和/或作为网络流量的服务。


## 配置选项

HHVM 有非常多的[配置选项](./INI-settings.md)。许多选项并不是为终端的 HHVM 用户准备的，但有一些关键的选项对任何部署 HHVM 的使用者都是有用的。

### INI 格式

HHVM 使用的是 [INI 格式](https://en.wikipedia.org/wiki/INI_file)的配置文件。在一个 INI 文件中，每一行都代表一个 key/value 格式的配置，其中 key 是选项的名称，而 value 是该选项的值。例如：

```
hhvm.force_hh = 1
hhvm.server_variables[MY_VARIABLE] = "Hello"
```

这些配置可以在两个地方中的一个地方指定，或在两者的组合中指定：

* 在配置文件中，通常后缀为 `.ini` (例如 `config.ini`)
* 在命令行运行 HHVM 时使用 `-d` 标志指定选项

```
hhvm -c config.ini file.php
hhvm -d hhvm.force_hh = 1 file.php
hhvm -c config.ini -d hhvm.log.file = /tmp/temp.log -d hhvm.force_hh = 1 file.php
```

如果同一个选项被指定了一次以上，那么 HHVM 会使用最后设置的选项。HHVM 从左到右读取命令行，自顶向下读取 INI 配置文件。

查看官方的 [INI 设置页面](/hhvm/configuration/INI-settings#common-options)，以了解可能会使用到的常用配置选项。

---

> *本节由 [Evilran](https://github.com/Evilran) 翻译*