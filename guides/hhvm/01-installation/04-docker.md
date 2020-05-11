我们将 HHVM 的 Docker 镜像发布到了 Docker Hub，你可以在容器化平台安装 HHVM。如果你之前没有用过 Docker，请参考他们的[入门教程](https://docs.docker.com/engine/getstarted/)。HHVM 的可用镜像都可以在[这里](https://hub.docker.com/u/hhvm/)找到（包括你现在看到的这个文档）。下面有一些例子，可以让你快速使用 Dokcer 将 HHVM 跑起来：

## 运行 HHVM 脚本

```
docker pull hhvm/hhvm
docker run --tty --interactive hhvm/hhvm:latest /bin/bash -l
hhvm --version
```

## 构建网站的 Docker 镜像

首先，按照以下步骤创建 Docker 镜像的文件和目录：

*`Dockerfile`*

```
FROM hhvm/hhvm-proxygen:latest

RUN rm -rf /var/www
ADD . /var/www

EXPOSE 80
```

*`public/index.php`*

```
<?hh

<<__EntryPoint>>
function main(): void {
  echo "Hello World!\n";
}
```

接着，在 shell 里执行：

```
docker build .
docker run -p 0.0.0.0:80:80 <Replace With The Hash Identifying The Build>
```

到此为止，你的 web server 就跑起来了，你用浏览器访问 http://localhost/ 就能访问到 *`index.php`* 这个文件。如果要关掉容器，执行下面的命令：

```
docker ps
docker stop <上一步执行 docker ps 时输出的 CONTAINER ID>
```

你可以在 [GitHub](https://github.com/hhvm-cn/user-documentation) 上查看本文档站的设置，以便了解它是怎么运作的。
Checkout the setup for this docsite on [github](https://github.com/hhvm/user-documentation) to see how this might scale.

### 最佳实践

`hhvm/hhvm-proxygen` 镜像的工作目录是 `/var/www/public`，默认入口文件是 `/var/www/public/index.php`，它将会处理 `/` 和 `/var/www/public` 中不存在的资源请求。**强烈建议** `public` 目录只存放允许用户直接访问的文件（通常来说就是 `index.php` 和诸如 css、js 以及图片这些静态资源），其他代码文件你可以放在其他任何位置。工程上常用的做法就是在项目根目录中新建一个 `public` 子目录，对于 `hhvm/hhvm-proxygen` 这个镜像来说就是将 `/var/www` 作为你项目的根目录。以本文档站为例，大部分代码都是放在 `src/` 的，在 `public/` 中只有[单一](https://github.com/hhvm-cn/user-documentation/blob/master/public/index.php)的 `index.php`，它作为入口文件，将会加载 `src/` 和 `vendor/` 中的代码并初始化堆栈。

这样做可以避免以下问题：
 - 泄漏配置文件中的敏感信息，例如数据库密码等
 - [因为 .git 或者 .hg 目录]((http://www.jamiembrown.com/blog/one-in-every-600-websites-has-git-exposed/))意外泄漏源码（包含历史版本信息）
 - 暴露不应该被远程执行的可执行脚本，例如 `bin/` 目录中的脚本
 - 暴露 `vendor/` 中的依赖，哪怕你的应用代码是安全的

---

> *本节由 [Y!an](https://yian.me/blog/) 翻译*