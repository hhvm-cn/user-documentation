HHVM 内置支持两种类型的 HTTP 服务：Proxygen 和 [FastCGI](/hhvm/advanced-usage/fastCGI)。

Proxygen 是内置在 HHVM 中完整的 Web 服务器。官方建议使用它，因为它在一般情况下是最容易启动和运行的。 它对 web 请求处理速度*快*。Proxygen 提供了一个高性能的 web 服务器，它的性能相当于 FastCGI 和 NGINX 的组合。

## 使用 Proxygen

在服务器模式下运行 HHVM 时使用 Proxygen：

```
hhvm -m server -p 8080
```

当然，你可以通过命令 `-d hhvm.server.port=7777` 来自定义端口号配置，或者在 `server.ini` 文件中写入 `hhvm.server.port=7777`。

由于 Proxygen 是默认的，你不需要明确地指定它为服务类型，但为了简洁起见，你可以在上面的命令中添加以下内容：`-d hhvm.server.type=proxygen`。

## Proxygen 配置示例

虽然没有 FastCGI/NGINX 组合的可配置性强，但 Proxygen 确实为许多应用程序提供了合理的默认值。因此，像上文简单的命令顺序启动 Proxygen 就可以了。


然而，这里有一些支持的配置选项的例子，你也可以添加/更改到你的 `server.ini` 文件或者通过命令行中的 `-d` 选项进行配置：

```
; some of these are not necessary since they are the default value, but
; they are good to show for illustration, and sometimes it is good for
; documentation purposes to be explicit anyway.
; hhvm.server.source_root and hhvm.server.port are the most likely ones
; that need explicit values.
hhvm.server.port = 80
hhvm.server.type = proxygen
hhvm.server.default_document = index.php
hhvm.server.error_document404 = index.php
; default is the current directory where you launched the HHVM binary
hhvm.server.source_root=/var/www/public
```

## 自动化服务的启动

HHVM Debian 预制包中的 init 脚本默认以 FastCGI 模式启动，如果你想自动地把 HHVM 作为一个服务启动，你需要做一些配置调整。请注意，这个设置是可选的；你也可以像上文一样手动地运行 HHVM，它会正常工作。

我们需要更改的配置在 `/etc/hhvm/server.ini` 文件中。 我们首先需要删除默认的以下这一行配置：

```
hhvm.server.type = fastcgi
```

我们还需要添加一行类似这样的内容，来告诉 HHVM 我们的源码在哪里。如下，替换 `/var/www` 为你的源码所在位置：

```
hhvm.server.source_root = /var/www
```

你可能还想修改 `hhvm.server.port` 选项；它默认设置为 `9000`，但是 `80` 或者 `8080` 可能会更加合适。 最后，如果你想修改错误日志的存储位置，请注意 `hhvm.log.file` 选项， 默认设置为 `/var/log/hhvm/error.log`，它足以适用于一般的应用程序。

然后，你可以运行以下命令来设置 HHVM 在开机时启动，并且现在就把它作为一个服务来启动。

```
sudo update-rc.d hhvm defaults
sudo service hhvm restart
```

---

> *本节由 [Evilran](https://github.com/Evilran) 翻译*