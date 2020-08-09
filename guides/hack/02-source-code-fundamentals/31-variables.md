我们通常会对具有类型和值的数据存储区域取个名字，然后称之为变量。不同的变量在不同的[作用域](scope.md)下可以有相同的名字。[常量](constants.md)也是一种变量，只不过它一旦初始化之后，值就不能改变。变量的作用域取决于声明它的上下文。

以下是你的代码中可能出现的几种变量类型：
 - [局部变量](#local-variables)
 - [数组元素](#array-elements)
 - [实例属性](#instance-properties)
 - [静态属性](#static-properties)
 - [类和接口常量](#class-and-interface-constants)

## Local Variables

Except for function parameters, a local variable is never defined explicitly; instead, it is created when it is first
assigned a value. A local variable can be assigned to as a parameter in the parameter list of a function definition or
inside any compound statement. It has function scope.

Consider the following example:

```Hack
function do_it(bool $p1): void {  // assigned the value true when called
  $count = 10;
  ...
  if ($p1) {
    $message = "Can't open master file.";
    ...
  }
  ...
}
do_it(true);
```

Here, the parameter `$p1` (which is a local variable) takes on the value `true` when `do_it` is called. The local
variables `$count` and `$message` take on the type of the respective value being assigned to them.

Consider the following example:

@@ variables-examples/local-variables.php @@

As you can see, the value of the local variable `$lv` is not preserved between
the function calls, so this function `f` outputs "`$lv = 1`" each time.

## Array Elements

An array is created via a vec-literal, a dict-literal, a set-literal, using `array`, or the
[array-creation operator](../expressions-and-operators/array-creation.md). At the same time, one or more elements
may be created for that array. New elements are inserted into an existing array via the
[simple-assignment](../expressions-and-operators/assignment.md) operator in conjunction with the
[subscript `[]`](../expressions-and-operators/subscript.md) operator.

The scope of an array element is the same as the scope of that array's name.

```Hack
$colors1 = vec["green", "yellow"];   // create a vec of two elements
$colors1[] = "blue";                 // add element 2 with value "blue"
$colors2 = dict[];                   // create an empty dict
$colors2[4] = "black";               // create element 4 with value "black"
$colors3 = array();                  // create empty array
$colors3 = ["red", "white", "blue"]; // create array<string> with 3 elements
$colors3[] = "green";                // insert a new element 3
```

## Instance Properties

实例属性在[类实例属性](../classes/properties.md)一节中有描述，它具有类的作用域。

## Static Properties

静态属性在[类静态属性](../classes/properties.md)一节中有描述，它具有类的作用域。

## Class and Interface Constants

类和接口常量在[类常量](../classes/constants.md)一节中有描述，它们具有类或者接口的作用域。

---

> *本节由 [Y!an](https://yian.me/blog/) 翻译*
