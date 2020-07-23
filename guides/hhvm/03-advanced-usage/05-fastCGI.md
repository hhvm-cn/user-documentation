HHVM 内置支持两种服务器类型：[Proxygen](../basic-usage/proxygen.md) 和 FastCGI。

FastCGI 在代码库和 web 服务器之间提供了一个高性能的接口（例如，请求之间的持久化进程等），但这显然也需要一个前端兼容的 web 服务器来处理请求（例如 [NGINX](http://nginx.org/)）。

## FastCGI 的工作原理

HHVM-FastCGI 的工作方式和 [PHP-FPM](http://php-fpm.org/) 差不多。在 FastCGI 模式下运行的 HHVM 是独立于 web 服务器（Apache、NGINX 等）启动的。它通过 TCP 套接字（按照惯例是 localhost:9000）或 UNIX 套接字进行监听。一般情况下 web 服务器在 80 端口或 443 端口监听。当有新的请求时，web 服务器要么建立一个连接到应用服务器，要么重新使用之前打开的一个连接，并使用 FastCGI 协议进行通信。然后，web 服务器继续解码 HTTP 协议，并向 HHVM 提供要执行的文件路径、请求头和请求体等信息。HHVM 运行计算并作出响应，再次使用 FastCGI 将其发回给 web 服务器。最后，web 服务器负责将 HTTP 响应发送给客户端。


## 使用 FastCGI

要在 FastCGI 模式下运行服务器，请将以下参数传递给 HHVM 运行时：

    hhvm --mode server -d hhvm.server.type=fastcgi -d hhvm.server.port=9000

现在服务器将接收在 localhost:9000 上的连接。要使用 UNIX 套接字，请使用 `Server.FileSocket` 选项替换：

    hhvm --mode server -d hhvm.server.type=fastcgi -d hhvm.server.file_socket=/var/run/hhvm/sock

要将服务模式改成守护进程模式，请更改模式的值：

    hhvm --mode daemon -d hhvm.server.type=fastcgi -d hhvm.server.file_socket=/var/run/hhvm/sock

要注意的是，所有 HHVM 运行时接受的常规选项也可以在 FastCGI 模式下使用，尤其是 `-d hhvm.admin_server.port=9001` 将创建一个额外的`管理服务器`，监听端口为 9001。

### 适配于 Apache 2.4

确保你已经通过类似的方式安装了 Apache：

```
sudo apt-get install apache2
```

官方建议使用 `mod_proxy` `mod_proxy_fcgi` 与 Apache 集成。首先启用模块，然后在 Apache 配置中，添加一行这样的内容：

    ProxyPass / fcgi://127.0.0.1:9000/path/to/your/www/root/goes/here/
    # Or if you used a unix socket
    # ProxyPass / unix://var/run/hhvm/sock|fcgi://127.0.0.1:9000/path/to/your/www/root/goes/here/

这将会路由*所有*的流量到 FastCGI 服务器。如果你只想路由特定的请求（例如，只有那些来自子目录或以 *.php 结尾的请求），你可以使用 `ProxyPassMatch`：

    ProxyPassMatch ^/(.*\.php(/.*)?)$ fcgi://127.0.0.1:9000/path/to/your/www/root/goes/here/$1

查阅 `mod_proxy_fcgi` 文档，以了解如何使用 `ProxyPass` 和 `ProxyPassMatch` 的更多细节。

另外，请确保在你的 Apache 配置中设置了一个 `DirectoryIndex`，像这样：

    <Directory /path/to/your/www/root/>
        DirectoryIndex index.php
    </Directory>

当你向一个目录发送请求时，这将尝试访问该目录下的 `index.php`。

### 适配于 NGINX

确保你已经通过类似的方式安装了 NGINX：

```
sudo apt-get install nginx
```

现在，NGINX 需要通过配置来了解你的 PHP 文件在哪里，以及如何将它们转发给 HHVM 来执行。相关的 NGINX 配置位于 `/etc/nginx/sites-available/default` -- 默认情况下，它在 `/usr/share/nginx/html` 中寻找文件，但它不知道如何处理 PHP。

我们包含的脚本 `sudo /opt/hhvm/<version>/share/hhvm/install_fastcgi.sh` 将正确配置 NGINX 的安装。重要的是，它在上面提到的 NGINX 配置的顶部添加了 `include hhvm.conf` -- 这将引导 NGINX 接收任何以 `.hh` 或 `.php` 结尾的文件，并通过 FastCGI 发送给 HHVM。

NGINX 默认的 FastCGI 配置在 HHVM-FastCGI 中应该可以正常工作。例如，你可能想在你的 `location` 指令中添加以下指令：

```
root /path/to/your/www/root/goes/here;
fastcgi_pass   127.0.0.1:9000;
# or if you used a unix socket
# fastcgi_pass   unix:/var/run/hhvm/sock;
fastcgi_index  index.php;
fastcgi_param  SCRIPT_FILENAME $document_root$fastcgi_script_name;
include        fastcgi_params;
```

`location` 指令范围内的流量现在将被路由到 HHVM-FastCGI 服务器。

*试验*

为了测试一切是否正常，将这个 Hello world 脚本写到 `hello.php` 中，放在 NGINX 寻找网页文件的目录下 -- 根据操作系统的不同，可能是 `/usr/share/nginx/html/hello.php` 或 `/var/www/html/hello.php` 又或者是其他地方：

```
<?php
    echo "Hello world!\n";
```

如果 HHVM 服务器没有运行，则启动它：

```
hhvm -m server -d hhvm.server.type=fastcgi -d hhvm.server.port=9000
```

然后加载 [http://localhost/hello.php](http://localhost/hello.php) ，验证有没有出现 "Hello world"。

注意，默认情况下 `/usr/share/nginx/html` 是只有 root 才有`写`权限，请使用 `chown` 来设置相应的权限，或者将 `/etc/nginx/sites-available/default` 指向不同的root，或者[参考 NGINX 文档](http://nginx.org/en/docs/)来做一些更花哨的事情。到这里基本上已经配置好了，所以你可以从一个已知的好的状态开始定制你的配置，这样如果以后出现了 Bug，很容易定位到是哪一个改动导致了问题的出现。

*NGINX 下的管理服务器*

如果你想通过 `-vAdminServer.Port=9001` 运行，那么类似这样就可以了：

```
location ~ {
    fastcgi_pass   127.0.0.1:9001;
    include        fastcgi_params;
}
```

---

> *本节由 [Evilran](https://github.com/Evilran) 翻译*