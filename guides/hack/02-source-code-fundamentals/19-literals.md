## 布尔字面量

字面量 `true` 和 `false` 分别表示布尔值“真”和“假”，布尔字面量的类型是 `bool`。比如：

```Hack
$val = true;
if ($val === false) ...
```

## 整数字面量

整数字面量可被写作十进制数、十六进制数（以 `0x` 或者 `0X` 作为前缀，包含有字母 A-F 或者是 a-f）、八进制数（以 `0` 开头），又或者是二进制数（以 `0b` 或者 `0B` 开头）。整数字面量的类型是 `int`。例如：

```Hack
$count = 10      // decimal 10
0b101010 >> 4    // binary 101010 and decimal 4
0XAf << 012      // hexadecimal Af and octal 12
```

## 浮点字面量

浮点字面量通常包含整数部分、小数点以及小数部分，也有可能会有指数部分。它们是用十进制数字来表示的。浮点字面量的类型是 `float`。例如：

```Hack
123.456 + 0.6E27 + 2.34e-3
```

预定义的常量 `INF` 和 `NAN` 分别提供对无穷大浮点值和非数字浮点值的访问。

## String Literals

字符串字面量可以是以下的任意一种形式：
* [单引号字符串](#string-literals__single-quoted-string-literals)
* [双引号字符串](#string-literals__double-quoted-string-literals)
* [heredoc 字符串](#string-literals__heredoc-string-literals)
* [nowdoc 字符串](#string-literals__nowdoc-string-literals)

字符串是以某种方式分隔的有零至多个字符组成的序列，分隔符不属于字符串的内容。字符串字面量的类型是 `string`。

### Single-Quoted String Literals

单引号字符串是由单引号（'）分隔的字符串文字，它允许包含除单引号（'）和反斜线（\\）以外的所有字符，单引号和反斜线需要用它们相应的转义字符，\\' 和 \\\\ 来表示。例如：

```Hack
'Welcome to Hack!'
'可以像这样嵌入单引号（\"）和反斜线（\\）'
```

### Double-Quoted String Literals

双引号字符串是由双引号（"）分隔的字符串文字，它允许包含除双引号（"）和反斜线（\\）以外的所有字符，双引号和反斜线需要用它们相应的转义字符，\\" 和 \\\\ 来表示。例如：

```Hack
"Welcome to Hack!"
"可以像这样嵌入双引号（\"）和反斜线（\\）"
```

其他某些（有时是不可打印的）字符也可以表示为转义序列。 *转义序列*表示的是单字符编码。 例如：

```Hack
"第一行1\n第二行2\n\n第四行\n"
"像这样就可以可以包含双引号（\"）和反斜线（\\）"
```

以下是受支持的转义序列：

转义序列 | 字符名 | Unicode 字符
--------------- | --------------| ------
\$  | 美元符 | U+0024
\"  | 双引号 | U+0022
\\\\  | 反斜线 | U+005C
\e  | 逃逸 | U+001B
\f  | 换页 | U+000C
\n  | 换行 | U+000A
\r  | 回车 | U+000D
\t  | 水平制表符 | U+0009
\v  | 垂直制表符 | U+000B
\ooo |  1-3位八进制数字值 ooo |
\xhh or \Xhh  | 1-2位十六进制数字值 hh | U+00hh
\u{xxxxxx} | UTF-8 编码的 Unicode 码点 U+xxxxxx | U+xxxxxx

在双引号字符串中，*没有*被反斜线（\\）转义的美元符（$）将用如下*变量替换规则*来处理。

当双引号字符串中遇到变量名时，它将会被求值并转换成字符串然后被替代到表达式中。下标或属性访问将分别根据[下标运算符](../expressions-and-operators/subscript.md)和[成员选择运算符](../expressions-and-operators/member-selection.md)的规则进行解析。 如果 `$` 后面的字符序列没有解析为可识别的名称，则 `$` 字符将逐字解释，并且不执行变量替换。

参考以下示例：

@@ literals-examples/dq-variable-substitution.php @@

### Heredoc 字符串

Heredoc 是一个由 “`<<< id`” 和 “`id`” 包括的字符串，它可以包含任意的原始字符， 其他某些（有时是不可打印的）字符也可以表示为[转义序列](#string-literals__double-quoted-string-literals)。Heredoc 支持对[双引号字符串](#string-literals__double-quoted-string-literals)中的变量进行替换。
举例：

@@ literals-examples/heredoc-literals.php @@

开始标记和结束标记必须是一样的，且 `<<<` 和开始标记之间只允许有水平方向的空格，开始标记到换行符之间不允许有空格；换行符和结束标记之间也不允许有空格。结束标记这行代码除了可选的分号（;）外，不允许有其他的字符——甚至哪怕是注释或者是空格。

### Nowdoc 字符串

Nowdoc 跟 `Heredoc` 长得很像，除了前者的开始标记是包含在单引号（'）中的。两种形式的字符串具有相同的语义和约束，只是 Nowdoc 不受变量替换规则的约束，例如：

@@ literals-examples/nowdoc-literals.php @@

开始标记和单引号（'）之间不允许有空格。

## 空字面量

有一个空字面量，`null`，其类型为 `null`。例如：

```Hack
function log(num $arg, ?num $base = null): float { ... }
```

在这里，`null` 被用作函数 `log` 的默认参数值。

在下面的例子中：

@@ literals-examples/null-literal.php @@

`null` 被用于初始化 shape 中的两个数据域。

---

> *本节由 [Y!an](https://yian.me/blog/) 翻译*
