```yamlmeta
{
  "fbonly messages": [
    "Unless you are specifically working on open source Hack code, you want [Facebook's internal documentation](https://our.internmc.facebook.com/intern/wiki/First-app/) instead."
  ]
}
```
## 概览

要学习 Hack 语言，你需要做的准备非常简单：

* [HHVM 运行时](../../hhvm/getting-started/getting-started.md)
* Hack 类型检查器（内置在 HHVM 里了）
* （可选）一个 Hack 范的编辑器。我们推荐使用 [Visual Studio Code] 然后安装
  [vscode-hack] 插件；或者你也可以用 Vim 并安装 [ALE]，一样可以得到不错的体验

## 第一个 Hack 程序

让我们开始循序渐进地开始学 Hack，先编写第一个 Hack 程序：

### 1. 安装 HHVM 和类型检查器

参考 [HHVM 快速指南](../../hhvm/getting-started/getting-started.md) 来学习安装 HHVM。

当你安装好 HHVM，你就可以使用 Hack 类型检查器来在你运行你的代码之前静态检查你的代码。类型检查器*不是*编译器，它是一个超快速的代码分析器，可以在代码运行之前而不是运行期间尽可能地将动态编程错误检查出来。

类型检查器在官方提供的 HHVM 包中叫做 `hh_client`；如果你用的是社区版的包，`hh_client` 应该也会包含在内，具体得联系包提供者。（译者注：强烈推荐使用官方包）

### 2. 配置类型检查器

选择一个目录来存放你的 Hack 代码，然后在这个目录中执行 `touch .hhconfig` 命令（译者注：Windows 下可以使用 `echo "" > .hhconfig` 命令）来创建一个空的配置文件，`hh_client` 会在你需要检查的代码的*根目录*读取这个文件。
为了正确地分析你的代码，类型检查器需要进行全局分析，也就是说它要能够读取所有代码。 这意味着它将为该根目录下的所有代码假定一个全局自动加载器，并将作为同一个项目递归检查该根目录下的所有代码。

### 3. 编写第一个 Hack 程序

打开你的编辑器（VSCode 或者 Vim 等等），然后创建一个名为 `first.hack` 的文件，输入以下代码：

@@ getting-started-examples/myfirstprogram.hack @@

我们暂时假定你已经具有一定的编程知识。Hack 跟 PHP 是非常相似的，而 Hack 又支持许多借鉴于 C、C++、C#、Java 和 JavaScript 的语法。下面是有关此示例的一些关键点：

* 此代码的命名空间是 `Hack\GettingStarted\MyFirstProgram`，命名空间可以随意指定，但必须是唯一的。
* `main` 是一个没有参数的函数，`void` 表示它没有返回值。这个函数是这段程序开始执行的地方，也就是说，`main` 函数是入口函数。
* `echo` 行是将一段文本和一个空行写入到标准输出中去。
* `printf` 也是将数据写入到标准输出去，但跟 `echo` 不同的是，它提供了格式化功能，比如在这个例子中，它将整型那一列右对齐了。
* `for` 循环中的变量 `$i` 将会从 -5 递增到 +5，每次递增 1；在每次循环中，`$i` 和它的平方会被一起输出到同一行里。

### 4. 运行类型检查器

如果你用的是 Visual Studio Code（安装有 vscode-hack 插件）或者是装有 ALE 的 Vim，你可以在编写代码的时候就看到检查信息。当然，你也可以在命令行中执行检查：

```
$ hh_client first.hack
```

你将会看到：

```
No errors!
```

### 5. 用 HHVM 来运行代码

当你编写完代码并检查无错误，你就可以用 HHVM 来运行你的程序了：

```
$ hhvm first.hack
```

输出：

```
Welcome to Hack!

Table of Squares
----------------
  -5        25
  -4        16
  -3         9
  -2         4
  -1         1
   0         0
   1         1
   2         4
   3         9
   4        16
   5        25
----------------

```

Now, go forth and Hack away!

---

> *本节由 [Y!an](https://yian.me/blog/) 翻译*

[Visual Studio Code]: https://code.visualstudio.com
[vscode-hack]: https://marketplace.visualstudio.com/items?itemName=pranayagarwal.vscode-hack
[ALE]: https://github.com/w0rp/ale
