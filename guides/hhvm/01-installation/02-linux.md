官方支持 x86_64 的 Linux 平台，同时为 Ubuntu 和 Debian 提供了安装包。

你也可以[自行编译](/hhvm/installation/building-from-source)，但官方再次提醒，最简单最稳定的做法就是安装官方提供的二进制包。

以下步骤可能需要 root 权限，请先通过 `su -` 或者 `sudo -i` 来获取 root 权限。

## 获取最新稳定版

### Ubuntu

```
apt-get update
apt-get install software-properties-common apt-transport-https
apt-key adv --recv-keys --keyserver hkp://keyserver.ubuntu.com:80 0xB4112585D386EB94

add-apt-repository https://dl.hhvm.com/ubuntu
apt-get update
apt-get install hhvm
```

### Debian 8 Jessie, Debian 9 Stretch

```
apt-get update
apt-get install -y apt-transport-https software-properties-common
apt-key adv --recv-keys --keyserver hkp://keyserver.ubuntu.com:80 0xB4112585D386EB94

add-apt-repository https://dl.hhvm.com/debian
apt-get update
apt-get install hhvm
```

## 获取特定的版本

如果你的代码兼容最新版，最好还是安装最新的版本。你可以通过往 `/etc/apt/sources.list` 添加源的方式来安装任何受支持的版本（除了 HHVM 3.30），具体操作如下：

`apt-add-repository "deb https://dl.hhvm.com/<%operating system%> <%operating system version%>-<%major%>.<%minor%> main"`

例如你想在 Ubuntu Bionic (18.04) 上安装 HHVM 4.8：
`apt-add-repository "deb https://dl.hhvm.com/ubuntu bionic-4.8 main"`

之后你可以获取到诸如 HHVM 4.8.1 的更新补丁，但不会更新到 HHVM 4.9 或者是更高的版本。

安装 HHVM 3.30 LTS 的操作如下：
`apt-add-repository "deb https://dl.hhvm.com/ubuntu bionic-lts-3.30 main"`
这就是以前发布LTS版本的方式。

## 如何选择 HHVM 的版本

如果是新项目，那么直接安装[最新稳定版](#获取最新稳定版)。

如果是已有项目，你可以根据[HHVM博客](//hhvm-cn.com/blog)中的重大更新说明来更新到一个较新的 HHVM 版本。

如果是你刚接手的项目，你不知道它之前是基于哪个版本开发的，你可以查看 composer.json 中的相关信息，composer.json 通常放在项目根目录（跟 .hhconfig 同级），它一般会包含类似 `"hhvm": "^4.8"` 的项，这就是这个项目要求的 HHVM 的版本。如果找不到 composer.json 这个文件或者文件中没有相关信息，那你可以查看最近的 git 提交时间，然后到[HHVM博客](//hhvm-cn.com/blog)中去找最接近这个时间点发布的版本。

请记住一点，无论如何都应该确保你选择的是仍然能够接收到安全补丁的版本，同样的，[HHVM博客](//hhvm-cn.com/blog)会告诉你哪些版本是还在受官方更新支持的。

## 其他包

上面的命令安装的是稳定、带有正式版配置的标准版 `HHVM`，你还可以通过以下命令来安装其他版本：

```
# 带有类似于 gdb 等调试器的稳定调试版
apt-get install hhvm-dbg

# 包含有头文件的稳定开发版（如果你在编写扩展，请安装这个版本）
apt-get install hhvm-dev

# Nightly build（尝鲜版，每天都会打包，不稳定）
apt-get install hhvm-nightly

# Nightly debug build（尝鲜调试版）
apt-get install hhvm-nightly-dbg

# Nightly developer build（尝鲜开发版）
apt-get install hhvm-dev-nightly

```

## GPG 密钥安装：替代方法

如果你使用 `apt-key adv` 时遇到问题，可以尝试以下方法：

```
apt-get install -y curl
curl https://dl.hhvm.com/conf/hhvm.gpg.key | apt-key add -
apt-key finger 'opensource+hhvm@fb.com'
```

请对比在执行 `apt-key finger` 之后输出的“指纹”，应该要一字不差得对上 `0583 41C6 8FC8 DE60 17D7  75A1 B411 2585 D386 EB94`，举个例子：

```
$ apt-key finger 'opensource+hhvm@fb.com'
pub   rsa4096 2017-11-03 [SC]
      0583 41C6 8FC8 DE60 17D7  75A1 B411 2585 D386 EB94
uid           [ unknown] HHVM Package Signing <opensource+hhvm@fb.com>
```

如果不是这种情况，请执行 `apt-key list`，然后用 `apt-key del` 删除所有您不认识的密钥。

## 镜像

官方为 dl.hhvm.com 架设了全球 CDN，因此对所有用户来说应该都很快。如果你希望维护本地镜像，可以使用 AWS CLI 实用程序进行同步：

```
aws s3 sync \
  --no-sign-request \
  --region us-west-2 \
  s3://hhvm-downloads/ \
  ./localpath/ \
  --exclude '*index.html'
```

[俄勒冈州立大学开放源实验室]（https://osuosl.org）维护了一个可用的镜像，你可以通过 HTTP/FTP/rsync 来访问它，网址：https://ftp.osuosl.org/pub/hiphop/ 。另外，它们只保留部分 nightly build。

---

> *本节由 [Y!an](https://yian.me/blog/) 翻译*
