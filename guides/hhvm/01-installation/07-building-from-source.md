一般来说，当你需要[官方提供的编译好的包](https://docs.hhvm-cn.com/hhvm/installation/introduction#prebuilt-packages)没有的功能时，建议从源码编译。 不然的话，直接安装官方提供的编译好的包是最简单和最稳定的方式。

## 编译环境要求

- `x86_64` 架构的系统
- 几个 GB 的内存
- macOS:
  - Sierra 或者 High Sierra
  - Xcode 命令行工具中的 Clang
- Linux:
  - GCC 5 或者 GCC 7
  - 目前仅支持在官方发布二进制包的发行版上编译；在其他官方未支持的系统上可能会遇到一些 Bug。

官方只支持使用绑定的 OCaml 进行编译；在编译 HHVM 之前，你可能需要卸载
（或者通过 macOS 上的 `brew unlink` 命令）其他 ocamlc 和 ocamlbuild 的二进制文件。

### GCC 5

如果你的 Linux 系统带有早期的 GCC，你必须重新编译 GCC 和 G++。 官方为二进制包提供了一个[轻量级编译的 bash 脚本](https://github.com/hhvm/packaging/blob/master/build-deps/build-gcc)。

HHVM 可以通过 GCC 4.9 编译，然而：
 - 官方不再对此进行测试
 - HHVM 会[在 GCC 4.9 中触发优化错误](https://github.com/facebook/hhvm/issues/8011)。

## 安装编译依赖

### Debian 或者 Ubuntu

如果你还没有添加官方的 apt 仓库（如安装二进制包）：

```
$ apt-get update
$ apt-get install software-properties-common apt-transport-https
$ apt-key adv --recv-keys --keyserver hkp://keyserver.ubuntu.com:80 0xB4112585D386EB94
```

安装编译依赖：

```
$ add-apt-repository -s https://dl.hhvm.com/debian
# - or - #
$ add-apt-repository -s https://dl.hhvm.com/ubuntu

$ apt-get update
$ apt-get build-dep hhvm-nightly
```

### Homebrew

```
$ brew tap hhvm/hhvm
$ brew deps --include-build hhvm | xargs brew install
```

### 其他 Linux 发行版

最好从[官方的的封装](https://github.com/hhvm/packaging/)中搜索 `Build-Depends:` 以确保你使用的是最新的依赖列表。

## 下载 HHVM 源码

```
git clone git://github.com/facebook/hhvm.git
cd hhvm
git submodule update --init --recursive
```

## 编译 HHVM

这将会花费 *很长* 的时间。

```
cmake -DMYSQL_UNIX_SOCK_ADDR=/var/run/mysqld/mysqld.sock .
make -j [number_of_processor_cores] # eg. make -j 4
sudo make install
```

### 自定义的 GCC

如果你编译了自定义的 GCC，你将需要向 cmake 传递额外的参数：

```
-DCMAKE_C_COMPILER=/path/to/gcc -DCMAKE_CXX_COMPILER=/path/to/g++ -DSTATIC_CXX_LIB=On
```

### macOS

在一些环境中，通过调度 cronjob 来杀死 `opendirectoryd` 的问题是很常见的；如果你正在这样做，请在编译 HHVM 之前禁用它，否则你在编译过程中很可能会得到误导性的错误， 如 `/bin/sh: /bin/sh: cannot execute binary file`。

即使从源码编译 HHVM，使用 [brew](https://brew.sh) 来管理编译环境也是最简单的：

```
$ brew sh
```

`brew sh` 会让你在一个规范化的编译环境中进入 bash shell - 如 `PATH` 包含了常见的编译工具。

在这个 bash shell 中：

```
# Several of our dependencies are not linked into standard places...

# ... some of the `brew sh` wrappers will remove CFLAGS/CXXFLAGS that reference undeclared dependencies
export HOMEBREW_DEPENDENCIES="$(brew deps --include-build hhvm | paste -s -d , -)"
# ... some of those use pkg-config, and we need to tell it where to look:
export PKG_CONFIG_PATH="$(echo "$HOMEBREW_DEPENDENCIES" | tr ',' "\n" | xargs brew --prefix | sed 's,$,/lib/pkgconfig,' | paste -s -d : -)"
# ... for others, CMake directly looks for specific files, and we need to tell it where to look too:
export CMAKE_PREFIX_PATH="$(echo "$HOMEBREW_DEPENDENCIES" | tr ',' "\n" | xargs brew --prefix | paste -s -d : -)"

# Configure.
# - If you install MySQL server from Homebrew, it uses /tmp/mysql.sock as the unix socket by default
# - Make sure that CMake uses Homebrew's preferred OSX SDK
# - set installation prefix for installing side-by-side with homebrew versions (optional)
cmake . \
  -DMYSQL_UNIX_SOCK_ADDR=/tmp/mysql.sock \
  -DCMAKE_OSX_SYSROOT=${HOMEBREW_SDKROOT} \
  $(brew diy --name=hhvm-local --version=$(date +%Y.%m.%d))
make # you probably want `make -j<number of cores`, e.g. `make -j12`
make install
```

## 运行程序

安装的 hhvm 可以在 `/usr/local/bin` 中找到。

## 错误处理

如果出现任何错误，你可能要删除检查中的 `CMakeCache.txt` 文件。

如果错误是在 `make` 命令过程中产生，尝试根据错误进行修改并再次运行 `make`，它应该从上次停止的地方开始。如果错误仍然存在，试着按照上文所说的删除 `CMakeCache.txt` 文件。

## 运行测试

如果你想运行回归测试，你需要先安装一些语言环境。 这些语言环境应该足够了，可能比实际需要的更多。

```
  sudo locale-gen en_EN
  sudo locale-gen en_UK
  sudo locale-gen en_US
  sudo locale-gen en_GB
  sudo locale-gen de_DE
  sudo locale-gen fr_FR
  sudo locale-gen fa_IR
  sudo locale-gen zh_CN.utf8
  sudo locale-gen zh_CN
```

回归测试一共有 2 组，大约 5000 个测试，所有的测试都应该通过。运行所有测试大约需要 100 个 CPU minutes，但测试运行器会根据每个核心一个线程的原则同时运行它们。

```
  pushd hphp
    test/run quick
    test/run slow
  popd
```

---

> *本节由 [Evilran](https://github.com/Evilran) 翻译*