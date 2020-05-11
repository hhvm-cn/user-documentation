我们曾试过用 Cygwin 来编译 HHVM，但是遇到了很多坑...从理论上来说，你也可以这么做，如果你不怕踩坑的话...

因此到目前为止，HHVM 官方没有提供 Windows 的支持，但是有个**好消息**...

## MSVC

有位[社区成员](https://github.com/facebook/hhvm/pulls?page=1&q=is%3Apr+author%3AOrvid&utf8=%E2%9C%93)正在尝试用 MSVC 在 Windows 上编译 HHVM，并且他取得了不错的进展，这使得我们在不久的将来就能在 Windows 上直接用 MSVC 来完整地编译 HHVM 了。

这项工作的第一步是让 HHVM 能够在 Windows 下编译，这里有一份含有详细信息的 [wiki](https://github.com/facebook/hhvm/wiki/Building-and-installing-HHVM-on-Windows-with-MSVC)。下一步是让代码能够在解释（interp）模式下运行，成功之后，JIT 也会被移植到 Windows 环境下。

[这里有一份清单](https://gist.github.com/Orvid/5c9bc8c54e960a604968)，记录了社区成员在做这项工作时遇到的问题以及解决方案。

---

> *本节由 [Y!an](https://yian.me/blog/) 翻译*