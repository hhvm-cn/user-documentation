Hack 的注释有三种写法：

@@ comments-examples/show-comment-styles.php @@

多行注释以 `/*` 开始、`*/` 结束。以 `/**` 开头的通常用于文档。

单行注释以 `//` 或者 `#` 开始，下一行结束。

还有一些可以被程序识别的特殊注释：

* `// FALLTHROUGH` 用于 [switch 语句](../statements/switch.md)
* `// strict` 和 `// partial` 用于 [起始标记](program-structure.md)
* `/* HH_FIXME[1234] */` 或者 `/* HH_IGNORE_ERROR[1234] */` 可以抑制类型检查器报告 1234 错误。

---

> *本节由 [Y!an](https://yian.me/blog/) 翻译*
