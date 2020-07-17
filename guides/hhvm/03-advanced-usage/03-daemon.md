你可以把 HHVM 作为一个守护进程来运行 (一个后台进程，而不是在用户的明确控制下的普通进程)，只需要把 `-m server` 替换成 `-m daemon`。

例如，以下是以 Proxygen 为后台，在守护进程模式下运行 HHVM 的例子：

```
hhvm -m daemon -d hhvm.server.type=proxygen -d hhvm.server.port=8080
```
通过 FastCGI 使用自定义的 `server.ini` 文件运行HHVM：

```
hhvm -m daemon -c server.ini -d hhvm.server.type=fastcgi -d hhvm.server.port=9000
```

---

> *本节由 [Evilran](https://github.com/Evilran) 翻译*