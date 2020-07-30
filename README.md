# HHVM/Hack 开发者中文文档 [![Build Status](https://api.travis-ci.org/hhvm-cn/user-documentation.svg?branch=master)](https://travis-ci.org/hhvm-cn/user-documentation)

本仓库包含 [HHVM/Hack开发者中文文档](https://github.com/hhvm-cn/user-documentation) 的文档和构建文档的源码，我们非常期待您能与我们一起翻译或者是[提出反馈](https://github.com/hhvm-cn/user-documentation/issues/new)！

## What?

以下是关于本仓库的三个关键点：

* **用户文档**： The [guides](https://github.com/hhvm-cn/user-documentation/tree/master/guides)。 We realized that finding out how to do simple things like setting up HHVM to more complicated things like using `async` were more tedious than they should be. The documentation should be a friend, not a nuisance.
* **API Reference**： We use our own HHVM code documentation for Hack and HHVM specific API documentation. And for anything PHP specific, we defer to [php.net](http://php.net). This serves two purposes:
    - The HHVM source code is the source of truth
    - We don't duplicate PHP documentation, and [their documentation](http://php.net) will serve as the source of truth for PHP-specific documentation
* **基础设施**： 一个更简单、更模块化、可扩展的记录文档的方式。我们用 Markdown 而不是 docbook 来编写[用户文档](https://github.com/hhvm-cn/user-documentation/tree/master/guides)的内容，用易于上手的基于 Hack 的[代码](https://github.com/hhvm-cn/user-documentation/tree/master/src)来构建文档站。

## How?

为了编写更好的文档，我们重新思考了文档的基础设施。

* 用 Markdown 代替 docbook 使得文档源代码的可读性提高了，也让后期更新更容易。
    - 有支持诸如示例插入等功能的扩展。
* 通过 Token 扫描 HHVM 代码的 docblock （而不是通过反射），使得重新构建 HHVM 时不一定需要更新文档。
  - 使用 [HHAST](https://github.com/hhvm/hhast) 和 [hh-apidoc](https://github.com/hhvm/hh-apidoc) 来解析 docblock。
* 确保构建站点的代码尽可能可复用，使得其具有可以不止是为 Hack 和 HHVM 构建文档站的能力。

检出[源码](https://github.com/hhvm-cn/user-documentation/tree/master/src) 来编译这个文档站。 [`bin/build.php`](https://github.com/hhvm-cn/user-documentation/blob/master/bin/build.php) 是构建的开端。

## 利用 Docker 搭建本地文档

如果你只是想快速地在本地搭建一个文档，你可以按如下步骤操作：

1. 安装 [Docker](https://docs.docker.com/engine/installation/)
2. 在终端执行 `docker run -p 8080:80 -d hhvmcn/user-documentation` 启动一个容器（这个时候你会看到终端输出了一个容器 ID）
3. 用浏览器访问 `http://localhost:8080`，就可以看到 HHVM/Hack 的（英文）文档了
4. 如果想停止容器，请在终端执行 `docker stop 第二步得到的容器ID`；如果你忘了复制第二步输出的容器ID，你可以执行 `docker ps` 来获取容器的名称或者ID，然后再执行 `docker stop 容器名称/容器ID`

## 构建文档

如果你想要在本地构建文档（例如预览你翻译的文档），你需要安装 PHP 7.0+/Composer 和 hhvm-4.52（本仓库从 Facebook 官方仓库 fork 出来时只能在 hhvm-4.52 下能构建成功）。

下面是很简易的教程，我们假定你已经安装好了相应的环境。点击[这里](installation-detailed.md)查看详细的安装文档。

当你安装好环境之后，按如下步骤即可在本地构建文档：

1. 克隆本仓库到本地
2. `cd path/to/user-documentation`
3. `php /path/to/composer.phar install`
4. `hhvm bin/build.php`

至此，文档已经构建好了，按照下面的步骤去启动一个 webserver

## 启动文档站

在 `public/` 目录中配置和启动 HHVM webserver，它会将所有没有命中实际文件的请求转发给 `index.php` 去处理（类似于 Laravel 等框架的 nginx url 重写配置）。在本地调试时，用 HHVM 内置的 webserver 已经足够了：

```
$ cd public
$ hhvm -m server -p 8080 -c ../hhvm.dev.ini
```

然后用浏览器访问 http://localhost:8080 即可
