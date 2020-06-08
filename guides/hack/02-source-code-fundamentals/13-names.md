名称用于标记变量、常量、函数以及用户自定义类型等。名称*必须*是由大写或者小写字母或者是下划线开头，后面可以跟其他字符或十进制数字，相同的也可以。

局部变量名、函数参数名和属性名*必须*以 `$` 开头，例如：

@@ names-examples/various-names.php @@

名称 `$_` 被称为`变量`，被保留用于[列出内部函数](../expressions-and-operators/list.md)和[foreach 语句](../statements/foreach.md)。

名称 `$this` 被预定义在实例方法或构造函数内部，用于对象调用自身方法。`$this`是只读的，它指定要在其上调用方法的对象或正在构造的对象。`$this` 的类型是 [`this`](../built-in-types/this.md)。

以双下划线（__）开头的名称被 Hack 语言保留。

注意，[XHP classes](../XHP/introduction)是另一种命名规则，类名可能会包含 `:`，并且一定是以 `:` 开头的。[XHP categories](../XHP/extending#children__categories) 的名称以 `%` 开头。

---

> *本节由 [Y!an](https://yian.me/blog/) 翻译*
