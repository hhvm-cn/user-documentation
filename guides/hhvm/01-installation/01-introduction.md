HHVM 官方支持安装在绝大部分主流的 [Linux 平台](./linux.md)和较新版本的 [macOS](./mac.md)。

## 编译好的二进制文件

安装 HHVM 最简单的方式就是下载官方提供的编译好的包，目前可以直接下载二进制文件的平台有：

* [部分 Debian 和 Ubuntu](./linux.md)
* [macOS](./mac.md)

### LTS/长期支持版本

除了常规稳定版，HHVM 还为上述平台提供了 [LTS （长期支持）版本](/hhvm/installation/linux#obtaining-lts-releases)；这里可以查阅详细的[发布计划](/hhvm/installation/release-schedule#Lifecycle)。

## 编译 HHVM

如果没有特殊情况，安装[官方提供的二进制文件](#编译好的二进制文件)是最简单最稳定的安装方式。如果你想尝鲜或者是有特殊需求，可以在 [GitHub](https://github.com/facebook/hhvm/) 获取到最新的源码来自己编译，关于在 Linux 和 macOS 下编译 HHVM 的步骤请参考[编译说明](/hhvm/installation/building-from-source)。

我们在提供编译好的二进制文件的同时也会提供其对应的代码。

### Hack 类型检查器

不管你是下载[编译好的二进制文件](#编译好的二进制文件)还是自行编译，都无需再另外安装 Hack 类型检查器。

## 不支持的平台/发行版

官方 wiki 中有关于不支持通过[包安装](https://github.com/facebook/hhvm/wiki/Prebuilt-Packages-for-HHVM)和[编译安装](https://github.com/facebook/hhvm/wiki/Building-and-Installing-HHVM)的平台/发行版列表。

---

> *本节由 [Y!an](https://yian.me/blog/) 翻译*