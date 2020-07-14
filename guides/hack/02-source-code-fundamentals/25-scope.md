相同的名称可以在代码中的不同地方表示不同的东西。对于名称表示的不同东西，它仅在某一范围内的代码中生效，这个范围我们称之为 *作用域*。作用域可以分为以下几种：
- 脚本，从声明/初始化到脚本结束，包括任意被[包含的脚本](script-inclusion.md)。
- 函数，从声明/初始化到[函数](../functions/defining-a-function)结束。
- 类，在类的内部，以及任意由此类派生的类（[定义一个类](../classes/defining-a-basic-class.md)）。
- 接口，在接口的内部，以及任意由此接口派生的接口，又或者是任意实现了此接口的类（[实现接口](../classes/implementing-an-interface.md)）。
- 命名空间，首次声明/初始化到[命名空间](../source-code-fundamentals/namespaces.md)结束。

在函数内部定义或初始化的变量拥有的是“函数作用域”。

每个函数都有它自己的作用域，[匿名函数](../functions/anonymous-functions.md)也有它自己的并且与其他已定义的匿名函数独立的作用域。

参数的作用域是声明它的函数的内部。出于作用域考虑，[try-catch](../statements/try.md) 块被视作一个函数体。

类（[定义一个类](../classes/defining-a-basic-class.md)）成员的作用域仅限于它本身或者是继承它的对象。类类型 `C` 是 `C` 的主体。

接口（[定义一个接口](../classes/implementing-an-interface.md)）成员的作用域仅限于它本身或者继承者，接口类型 `I` 是 `I` 的主体。

当 [trait](../classes/using-a-trait.md) 被用在类或者接口内部时，trait 的成员将被赋予该类或接口的作用域。

---

> *本节由 [Y!an](https://yian.me/blog/) 翻译*
