macOS 用户可以通过 [Homebrew](http://brew.sh/) 来安装 HHVM：

```
brew tap hhvm/hhvm
brew install hhvm
```

这两个命令可以在最近版本的 macOS （截止 2019-03-12，最近版本的 macOS 指的是 Mojave 和 High Sierra，译者在 2020.04 的时候在 Catalina 上成功安装了 HHVM 4.52）上安装二进制包。如果没有可用的二进制包（或者你用了 `--build-from-source` 参数），大概会花 20 分钟（Mac Pro）至几个小时（MacBook Air）不等来编译 HHVM。

除了安装最新稳定版，你也可以通过以下方式来安装其他版本：

- `brew install hhvm-nightly`: 安装最近的 nightly build
- `brew install hhvm-VERSION`: 安装指定的版本，例如：
  `brew install hhvm-4.8` 或者 `brew install hhvm-3.30`

你也可以不通过 Homebrew，[自行下载源码编译](building-from-source#building-hhvm__macos).

---

> *本节由 [Y!an](https://yian.me/blog/) 翻译*