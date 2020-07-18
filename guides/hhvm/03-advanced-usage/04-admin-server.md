管理服务器允许 HHVM 服务的管理员查询和控制 HHVM 服务进程。它和使用 `-m server` 或者 `-m daemon` 指定的 HHVM 主服务是不一样的，而且是独立分开的。

要启动管理服务器，你可以在命令行通过 `-d` 或者在 `server.ini`（或其他等同的配置文件） 中指定以下选项：

```
hhvm.admin_server.port=9001
hhvm.admin_server.password=SomePassword
```

`端口`可以是任何开放的端口。而且你**应该指定一个密码**来保护管理端口，因为你不希望任何人都能控制你的服务器。实际上，你可能想把管理服务器*放在防火墙监管下*，那么你需要在每次请求管理端口时指定密码。

管理服务器与主服务器使用相同的协议 - 因此，如果你使用 [FastCGI](/hhvm/advanced-usage/fastCGI) 模式，管理服务器也将是 FastCGI，你需要另外配置一个 web 服务器（如 NGINX）。如果你使用的是 [Proxygen](../basic-usage/proxygen.md) 模式，管理服务器将是一个 HTTP 服务器。


## 查询管理服务器

一旦你设置好了管理服务器，你就可以通过 `curl` 来查询它。

```
curl http://localhost:9001/
```

这个命令会显示一个你可以用来控制和查询管理服务器的命令列表。

如果你使用的是 [Proxygen](/hhvm/basic-usage/proxygen)，那么与 `curl` 命令相关联的端口就是上文设置的 `hhvm.admin_server` 端口，*如果你使用的是 [FastCGI](/hhvm/advanced-usage/fastCGI)*，那么这个端口就是 FastCGI 的web 服务端口。

### 发送命令

使用上文中带有 `curl` 的指令，加上你的密码，向管理服务器发送命令。


```
curl http://localhost:9001/compiler-id?auth=SomePassword
```

## 进一步参考

这里有一篇好的[博客文章](http://hhvm.com/blog/521/the-adminserver)更进一步讨论了管理服务器。

---

> *本节由 [Evilran](https://github.com/Evilran) 翻译*