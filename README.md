# HHVM/Hack 开发者中文文档 [![Build Status](https://api.travis-ci.org/hhvm-cn/user-documentation.svg?branch=master)](https://travis-ci.org/hhvm-cn/user-documentation)

本仓库包含 [HHVM/Hack开发者中文文档](https://github.com/hhvm-cn/user-documentation) 的文档和构建文档的源码，我们非常期待您能与我们一起翻译或者是[提出反馈](https://github.com/hhvm-cn/user-documentation/issues/new)！

## What?

There are three keys areas to this repo:

* **User Documentation**: The [guides](https://github.com/hhvm/user-documentation/tree/master/guides). We realized that finding out how to do simple things like setting up HHVM to more complicated things like using `async` were more tedious than they should be. The documentation should be a friend, not a nuisance.
* **API Reference**: We use our own HHVM code documentation for Hack and HHVM specific API documentation. And for anything PHP specific, we defer to [php.net](http://php.net). This serves two purposes:
    - The HHVM source code is the source of truth
    - We don't duplicate PHP documentation, and [their documentation](http://php.net) will serve as the source of truth for PHP-specific documentation
* **Infrastructure**: An easier, more modular and scalable way for documentation. Markdown, not docbook, for [user-guide](https://github.com/hhvm/user-documentation/tree/master/guides) content. Easy to follow, Hack-based [source code](https://github.com/hhvm/user-documentation/tree/master/src) for building the site.

## How?

Our strategy to create better documentation begins with a re-thinking of our doc infrastructure.

* Markdown instead of docbook provides an easier path for documentation source readability and updates.
    - Have extensions to support things like example insertion, etc.
* Token scan our the HHVM code block documentation (instead of reflection) so that rebuilding HHVM isn't necessary to update the documentation.
  - Use [HHAST](https://github.com/hhvm/hhast) and [hh-apidoc](https://github.com/hhvm/hh-apidoc) for docblock parsing
* Ensure the source code that builds the site is as reusable as possible, so that it has the potential to provide reusability to documentation projects beyond Hack and HHVM.

Check out the [source code](https://github.com/hhvm/user-documentation/tree/master/src) for building the site. [`bin/build.php`](https://github.com/hhvm/user-documentation/blob/master/bin/build.php) is where all the execution begins.

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
