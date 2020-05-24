## Hack 标准库（HSL）

Hack 标准库正在快速迭代，目前是与 HHVM 独立分发的，这里有两个 GitHub 项目/composer 包：

- [hhvm/hsl](https://github.com/hhvm/hsl/)： Hack 标准库
- [hhvm/hsl-experimental](https://github.com/hhvm/hsl-experimental/)：实验功能，有些可能会在未来加入到 Hack 标准库中去

设计理念包括：
- 完美适配 Hack 类型系统和总体设计
- 内部一致性和可预测性
- 提供简洁的基础构建模块而不是许多高阶方法

HSL 的功能靠命名空间来分类，命名空间能表明库的类型（也有可能会有更细粒度的分隔，例如按照返回类型来区分），例如：

- `HH\Lib\Str` 包含了与字符串操作相关的函数，例如 `Str\contains()`
- `HH\Lib\Dict` 包含了返回 `dict` 的函数，例如 `Dict\map()`
- `HH\Lib\Vec` 包含了返回 `vec` 的函数，例如 `Vec\map()`
- `HH\Lib\C` 包含了在 `C`ontainers （容器）上操作的函数，但是不返回或不依赖特定的容器，例如 `C\contains()`

你可以在 [API](/hsl/reference/) 中看到完整的列表，并且这里还有一个关于[容器操作]的常用函数的表格。

---

> *本节由 [Y!an](https://yian.me/blog/) 翻译*

[容器操作]: /hack/built-in-types/arrays#using-dicts-keysets-and-vecs
