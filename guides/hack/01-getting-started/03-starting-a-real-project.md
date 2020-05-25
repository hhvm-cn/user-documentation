## 项目实战

实际项目往往不会只有一个独立的文件，而是会依赖于各种库或包，例如[Hack 标准库]或者是其他一些可选的工具。

一个良好的项目应该是这样启动的：
- [安装 Composer]
- 创建一个空白的 `.hhconfig` 文件
- 创建 `src/` 和 `tests/` 子目录
- 配置自动加载
- 使用 Composer 来安装公共依赖和工具

### 自动加载

在 HHVM 中是没有“编译”这个步骤的，每个文件都是按需执行。当前，我们需要为 HHVM 提供哪个文件定义了哪些类/函数等的映射关系，例如，当执行代码 `new Foo()` 的时候，HHVM 需要知道 `Foo` 类是定义在 `src/Foo.hack` 的。

[hhvm-autoload] 可以生成这种映射关系。你可以通过以下命令将 hhvm-autoload 添加到你的项目中去：

```
$ php /path/to/composer.phar require hhvm/hhvm-autoload
```

hhvm-autoload 的配置文件是 `hh_autoload.json`。对于大多数项目而言，最简单的配置结构如下：

```JSON
{
  "roots": [
    "src/"
  ],
  "devRoots": [
    "tests/"
  ],
  "devFailureHandler": "Facebook\\AutoloadMap\\HHClientFallbackHandler"
}
```

`roots` 节点指定生产环境中需要加载的目录

`devRoots` 节点中的是开发和测试环境中需要自动加载的目录，在生产环境中时这些目录不会被加载

`devFailureHandler` 是后备策略的完全限定名称。当你添加了一个新的类或者函数并且没有执行 `hh-autoload` 时，自动加载映射关系不会被自动更新。HHVM 在自动加载映射中找不到你的类型、常量或者是函数等时，就会调用后备。

后备会尝试在运行时加载类型、常量或者是函数等等（此过程会大大降低代码执行速度，因此不应该在生产环境中使用它）。同时，不是所有的常量或函数都能/会被 HHClientFallbackHandler 找到，你可以在 [GitHub 仓库](https://github.com/hhvm/hhvm-autoload) 中查阅更多信息。

一旦配置文件创建好，`vendor/bin/hh-autoload` 就可以用来生成或更新映射表并创建 `vendor/autoload.hack`

### 例子

按顺序执行以下命令可以完整地初始化一个带有常用依赖的 Hack 项目：

```
$ touch .hhconfig
$ mkdir bin src tests
$ cat > hh_autoload.json
{
  "roots": [
    "src/"
  ],
  "devRoots": [
    "tests/"
  ],
  "devFailureHandler": "Facebook\\AutoloadMap\\HHClientFallbackHandler"
}
$ composer require hhvm/hsl hhvm/hhvm-autoload
$ composer require --dev hhvm/hhast hhvm/hacktest facebook/fbexpect
```

由于 Composer 安装方式可能不一样，你在使用 Composer 的时候可能需要使用绝对路径。

以下是同样的命令，以及其输出（译者注：在你的机器上可能会略有不同）：

```
$ touch .hhconfig
$ mkdir bin src tests
$ cat > hh_autoload.json
{
  "roots": [
    "src/"
  ],
  "devRoots": [
    "tests/"
  ],
  "devFailureHandler": "Facebook\\AutoloadMap\\HHClientFallbackHandler"
}
$ composer require hhvm/hsl hhvm/hhvm-autoload
Using version ^4.0 for hhvm/hsl
Using version ^2.0 for hhvm/hhvm-autoload
./composer.json has been created
Loading composer repositories with package information
Updating dependencies (including require-dev)
Package operations: 2 installs, 0 updates, 0 removals
  - Installing hhvm/hsl (v4.0.0): Loading from cache
  - Installing hhvm/hhvm-autoload (v2.0.3): Loading from cache
Writing lock file
Generating autoload files
/var/folders/3l/2yk1tgkn7xdd76bs547d9j90fcbt87/T/tmp.xaQwE1xE/vendor/autoload.hack
$ composer require --dev hhvm/hhast hhvm/hacktest facebook/fbexpect
Using version ^4.0 for hhvm/hhast
Using version ^1.4 for hhvm/hacktest
Using version ^2.5 for facebook/fbexpect
./composer.json has been updated
Loading composer repositories with package information
Updating dependencies (including require-dev)
Package operations: 7 installs, 0 updates, 0 removals
  - Installing facebook/difflib (v1.1): Loading from cache
  - Installing hhvm/hsl-experimental (v4.0.1): Loading from cache
  - Installing hhvm/type-assert (v3.3.1): Loading from cache
  - Installing facebook/hh-clilib (v2.1.0): Loading from cache
  - Installing hhvm/hhast (v4.0.4): Loading from cache
  - Installing hhvm/hacktest (v1.4): Loading from cache
  - Installing facebook/fbexpect (v2.5.1): Loading from cache
Writing lock file
Generating autoload files
/private/var/folders/3l/2yk1tgkn7xdd76bs547d9j90fcbt87/T/tmp.xaQwE1xE/vendor/autoload.hack
$
```

### 添加函数或者类

作为一个实验性例子，我们将会创建一个函数，它可以遍历计算数字向量的平方值。保存下面的代码到 `src/square_vec.hack`：

```Hack
use namespace HH\Lib\Vec;

function square_vec(vec<num> $numbers): vec<int> {
  return Vec\map($numbers, $number ==> $number * $number);
}
```

如果你运行 `hh_client`，它会向你报一个错：

```
src/square_vec.hack:4:10,57: Invalid return type (Typing[4110])
  src/square_vec.hack:3:53,55: This is an int
  src/square_vec.hack:4:40,56: It is incompatible with a num (int/float) because this is the result of an arithmetic operation with a num as the first argument, and no floats.
  src/square_vec.hack:3:35,35: Here is why I think the argument is a num: this is a num
```

这时只需要将返回类型由 `vec<int>` 改成 `vec<num>` 即可修复

到此我们就有了一个合法的 Hack 函数，但它没有被测试过，也没有被调用。

### 添加可执行程序

将下面的代码保存为 `bin/square_some_things.hack`:

```Hack
#!/usr/bin/env hhvm

require_once(__DIR__.'/../vendor/autoload.hack');

<<__EntryPoint>>
async function main(): Awaitable<void> {
  \Facebook\AutoloadMap\initialize();

  $squared = square_vec(vec[1, 2, 3, 4, 5]);
  foreach ($squared as $square) {
    printf("%d\n", $square);
  }
}
```

这段程序：
 - 载入并初始化了自动加载器，使得上面我们定义的函数可以被加载进来
 - 调用了之前定义的函数
 - 打印了函数结果

`<<__EntryPoint>>` 注解将这个函数标记为这段可执行程序在被执行时的入口（函数名 `main` 没有特别之处）。

现在你可以用 HHVM 显式地执行你的新程序，或者将其标记为可执行文件来执行（译者注：在代码文件中的第一行加入 `#!/usr/bin/env hhvm`，这种写法叫做 `Shebang` 或者 `Hashbang`）：

```
$ hhvm bin/square_some_things.hack
1
4
9
16
25
$ chmod +x bin/square_some_things.hack
$ bin/square_some_things.hack
1
4
9
16
25
```

### Linting

大多数项目都会使用 linter 来执行一些代码风格化，尽管不是语言本身要求的，但这么做可以使得你的代码风格看起来更加一致。[HHAST] 是推荐用于 Hack 代码的 linter。HHAST 的 linter 由项目根目录中的 `hhast-lint.json` 启用。一个好的新项目应该为所有包含代码的目录开启所有 linters。将下面的内容保存为 `hhast-lint.json`：

```json
{
  "roots": [ "bin/", "src/", "tests/" ],
  "builtinLinters": "all"
}
```

在之前执行 `composer require` 的时候，HHAST 已经被安装到 `vendor/` 子目录了，你可以直接执行：

```
$ vendor/bin/hhast-lint
Function "main()" does not match conventions; consider renaming to "main_async"
  Linter: Facebook\HHAST\Linters\AsyncFunctionAndMethodLinter
  Location: /private/var/folders/3l/2yk1tgkn7xdd76bs547d9j90fcbt87/T/tmp.xaQwE1xE/bin/square_some_things.hack:5:0
  Code:
  >
  ><<__EntryPoint>>
  >async function main(): Awaitable<void>
```

### 单元测试

[HackTest] 被用于创建单元测试类，而 [fbexpect] 被用于表达断言。我们创建一个基本的测试 `tests/MyTest.hack`：

```hack
use function Facebook\FBExpect\expect;
use type Facebook\HackTest\{DataProvider, HackTest};

final class MyTest extends HackTest {
  public function provideSquaresExamples(): vec<(vec<num>, vec<num>)> {
    return vec[
      tuple(vec[1, 2, 3], vec[1, 4, 9]),
      tuple(vec[1.1, 2.2, 3.3], vec[1.1 * 1.1, 2.2 * 2.2, 3.3 * 3.3]),
    ];
  }

  <<DataProvider('provideSquaresExamples')>>
  public function testSquares(vec<num> $in, vec<num> $expected_output): void {
    expect(square_vec($in))->toBeSame($expected_output);
  }
}
```

然后我们可以用 HackTest 来运行测试：

```
$ vendor/bin/hh-autoload
$ vendor/bin/hacktest tests/
..

Summary: 2 test(s), 2 passed, 0 failed, 0 skipped, 0 error(s).
```

不是所有时候都需要重新生成自动加载映射表（用 hh-autoload），但是如果类在自动加载映射表中找不到时，你可能会得到有关反射类不存在的异常。因此建议在执行测试套件之前，确保自动加载映射表时完整的。

如果我们人为加入一个错误，例如 `tuple(vec[1, 2, 3], vec[1, 2, 3])`，HackTest 会报：

```
$ vendor/bin/hacktest tests/
..F

1) MyTest::testSquares with data set #3 (vec [
  1,
  2,
  3,
], vec [
  1,
  2,
  3,
])

Failed asserting that vec [
  1,
  4,
  9,
] is the same as vec [
  1,
  2,
  3,
]

/private/var/folders/3l/2yk1tgkn7xdd76bs547d9j90fcbt87/T/tmp.xaQwE1xE/tests/MyTest.hack(15): Facebook\FBExpect\ExpectObj->toBeSame()


Summary: 3 test(s), 2 passed, 1 failed, 0 skipped, 0 error(s).
```

## 配置 Git

`vendor/` 目录不应该提交到 Git；在其他系统或分支，用 `composer install` 来安装依赖。这个操作会使用已经生成好的 `composer.lock` （这个文件应该提交到 Git）来安装相同版本的依赖。

```
$ echo vendor/ > .gitignore
```

如果你编写的是库，那这个库的用户可能不想要你的单元测试，因为如果包含了你的单元测试，他们需要安装兼容版本的 `fbexpect` 和 `hacktest`才不会得到 Hack 报错。

由于 Composer 使用的 GitHub releases 是由 `git export` 自动打包的，因此最简单的方式就是通过配置 `git export` 来忽略 `tests/` 目录：

```
$ echo 'tests/ export-ignore' > .gitattributes
```

## 配置 TravisCI

我们推荐在 TravisCI 上使用 Docker 来对 Hack 项目进行持续集成。我们通常通过创建在容器中单独执行的 `.travis.sh` 来实现。举个例子，一份 `.travis.tml` 大概会长下面这样：

```
sudo: required
language: generic
services: docker
env:
- HHVM_VERSION=latest
- HHVM_VERSION=nightly
install:
- docker pull hhvm/hhvm:$HHVM_VERSION
script:
- docker run --rm -w /var/source -v $(pwd):/var/source hhvm/hhvm:$HHVM_VERSION ./.travis.sh
```

... 及其对应的 `.travis.sh`:

```
#!/bin/sh
set -ex
apt update -y
DEBIAN_FRONTEND=noninteractive apt install -y php-cli zip unzip
hhvm --version
php --version

(
  cd $(mktemp -d)
  curl https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
)
composer install

hh_client
vendor/bin/hacktest tests/
if !(hhvm --version | grep -q -- -dev); then
  vendor/bin/hhast-lint
fi
```

使用以上配置，TravisCI 在运行的时候将会检查 Hack 错误、单元测试失败；以及在发布构建时执行 `hhast-lint`。我们不在 `-dev` 构建时执行 `hhast-lint`，因为 `hhast-lint` 依赖与 HHVM/Hack 的实现细节，而 HHVM/Hack 的实现细节迭代得很频繁。

---

> *本节由 [Y!an](https://yian.me/blog/) 翻译*

[fbexpect]: https://github.com/hhvm/fbexpect
[HackTest]: https://github.com/hhvm/hacktest
[HHAST]: https://github.com/hhvm/hhast
[Hack 标准库]: https://github.com/hhvm/hsl/
[hhvm-autoload]: https://github.com/hhvm/hhvm-autoload
[安装 Composer]: https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos
