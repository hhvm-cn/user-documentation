## 工具

主要工具有：

- `hh_client`：命令行模式下的 Hack 静态分析接口，被用于验证某项目代码是否是有效的 Hack 程序，以及被用于检查程序中的错误
- `hhvm`：用于执行你的 Hack 代码，可用于 CLI（比如 `hhvm foo.hack`）模式或者是 server 模式，这里有[丰富的文档](/hhvm/)

### 编辑器和 IDE

你可以用任何文本编辑器来编辑 Hack 文件，并且有许多编辑器都有跟 Hack 相关的增强插件。

我们主推在 [Visual Studio Code] 上安装 [VSCode-Hack] 扩展来进行 Hack 项目开发，它们能提供跟常规 IDE 很接近的体验，诸如语法高亮、转到定义以及行内显式 Hack 错误等等都是支持的。

对于 Vim 用户，[vim-hack] 提供了语法高亮和语言检测，[ALE] 则提供了 Hack 的增强支持。

[hack-mode] 则是为 Emacs 用户提供了 Hack 支持。

如果你用的编辑器或者 IDE 支持 [Language Server Protocol]，那么请在编辑器/IDE配置中设置成使用 `hh_client lsp`；如果你用的是 [HHAST]，你可能需要设置成使用 `vendor/bin/hhast-lint --mode lsp`，请注意，这样会让你的编辑器在打开项目时就自动执行你的代码，由于这个原因，ALE 默认是将 HHAST 禁用的，而 VSCode 则是会在执行代码前弹窗确认。

### 依赖管理

目前 Hack 的依赖管理用的是 [Composer]，并且 Composer 要用 PHP 来运行。你可以将 Composer 理解成是 `npm` 或者 `yarn` 那样的东西。

### 其他通用工具

- `hackfmt` 是 CLI 模式下的代码格式化工具，已经包含在 HHVM/Hack 里了，并且它被集成到许多编辑器或者 IDE 中去了
- [HHAST] 加入了代码风格提示，以及自动修改代码来适配语言或者库的改动的能力
- [hacktest] 和 [fbexpect] 通常会一起用于编写单元测试

---

> *本节由 [Y!an](https://yian.me/blog/) 翻译*

[ALE]: https://github.com/w0rp/ale
[Composer]: https://getcomposer.org
[HHAST]: https://github.com/hhvm/hhast
[VSCode-Hack]: https://github.com/slackhq/vscode-hack/
[Visual Studio Code]: https://code.visualstudio.com
[Language Server Protocol]: https://microsoft.github.io/language-server-protocol/
[fbexpect]: https://github.com/hhvm/fbexpect
[hack-mode]: https://github.com/hhvm/hack-mode
[hacktest]: https://github.com/hhvm/hacktest
[vim-hack]: https://github.com/hhvm/vim-hack
