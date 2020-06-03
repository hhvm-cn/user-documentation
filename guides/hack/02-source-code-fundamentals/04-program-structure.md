一个 Hack 程序包含一个或多个源文件，这些源文件的扩展名应为 `.hack`，并包含以下一个或多个类型的声明（无须按以下顺序）：


* 别名声明
* 类
* 枚举类型
* 函数
* 包含指令
* 接口
* 命名空间
* trait
* use

参考以下代码：

@@ program-structure-examples/hello-world.hack @@

在这个例子中，启动函数被定义为 `main`，但实际上，你可以用任意一个名字，例如 `run`，`do_it` 或者是 `make_magic` 都可以（让 `main` 成为启动函数的是[`__EntryPoint` 属性](../attributes/predefined-attributes#__entrypoint)）

## 包含其他文件

一个文件可以通过[包含](script-inclusion.md)来导入其他文件。

## 旧版文件

在以前的 Hack 代码文件，可能还用着 `.php` 扩展名，但是在新的 Hack 代码中，不推荐使用这个扩展名了。如果 Hack 代码还是继续用 `.php` 扩展名的话，则必须在第一行中加入 shebang（例如 `#!/usr/bin/env hhvm`），然后才是起始标记行。起始标记可以是以下任意一种：

- `<?hh // strict`：这是目前推荐的起始标记，会使得 Hack 代码在严格模式运行
- `<?hh // partial`：放宽了一些限制，以降低从其他语言迁移过来的成本，强烈不建议用在新的项目中。
- `<?hh`：取决于 HHVM/Hack 的版本，可能等同于 strict 或者是 partial，也可能会直接抛一个错误。强烈不建议将这种写法用在新的以及现有的代码上面。
- `<?hh // decl`：不再被支持

下面的代码等同于之前的例子：

@@ program-structure-examples/legacy.php @@

---

> *本节由 [Y!an](https://yian.me/blog/) 翻译*
