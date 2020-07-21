HHVM 提供了几十个内置的以及集成的扩展，并允许动态加载其他扩展。由于这是 HHVM 的用户指南，所以在这里我们不讨论如何构建自己的扩展，但下面列出了相关的资源。


## 集成扩展

如果你从 HHVM 中调用 `get_loaded_extensions()`，你会发现以下扩展已经被集成到 HHVM 中了：

* [apache](http://php.net/manual/en/book.apache.php)
* [apc](http://php.net/manual/en/book.apc.php)
* [array](http://php.net/manual/en/book.array.php)
* [asio](/hack/asynchronous-operations/utility-functions)
* [async_mysql](/hack/asynchronous-operations/extensions#mysql)
* [bc](http://php.net/manual/en/book.bc.php)
* [bz2](http://php.net/manual/en/book.bzip2.php)
* [ctype](http://php.net/manual/en/book.ctype.php)
* [curl](http://php.net/manual/en/book.curl.php) ([async curl](/hack/asynchronous-operations/extensions#curl))
* [date](http://php.net/manual/en/book.date.php)
* [debugger](http://php.net/manual/en/book.debugger.php)
* [dom](http://php.net/manual/en/book.dom.php)
* domdocument
* [enum](/hack/built-in-types/enumerated-types)
* [exif](http://php.net/manual/en/book.exif.php)
* fb
* [fileinfo](http://php.net/manual/en/book.fileinfo.php)
* [filter](http://php.net/manual/en/book.filter.php)
* [gd](http://php.net/manual/en/book.gd.php)
* [gmp](http://php.net/manual/en/book.gmp.php)
* [hash](http://php.net/manual/en/book.hash.php)
* hhvm.debugger
* hhvm.ini
* hosthealthmonitor
* hotprofiler
* [iconv](http://php.net/manual/en/book.iconv.php)
* [idn](http://php.net/manual/en/ref.intl.idn.php)
* [imagick](http://php.net/manual/en/book.imagick.php)
* [imap](http://php.net/manual/en/book.imap.php)
* intervaltimer
* [intl](http://php.net/manual/en/book.intl.php)
* [json](http://php.net/manual/en/book.json.php)
* [ldap](http://php.net/manual/en/book.ldap.php)
* [libxml](http://php.net/manual/en/book.libxml.php)
* [mail](http://php.net/manual/en/book.mail.php)
* [mailparse](http://php.net/manual/en/book.mailparse.php)
* [mbstring](http://php.net/manual/en/book.mbstring.php)
* [mcrouter](/hack/asynchronous-operations/extensions#mcrouter)
* [mcrypt](http://php.net/manual/en/book.mcrypt.php)
* [memcache](http://php.net/manual/en/book.memcache.php)
* [memcached](http://php.net/manual/en/book.memcached.php)
* objprof
* [openssl](http://php.net/manual/en/book.openssl.php)
* [pcntl](http://php.net/manual/en/book.pcntl.php)
* [pcre](http://php.net/manual/en/book.pcre.php)
* [pdo](http://php.net/manual/en/book.pdo.php)
* [pdo_mysql](http://php.net/manual/en/ref.pdo-mysql.php)
* [pdo_pgsql](http://php.net/manual/en/ref.pdo-pgsql.php)
* [pdo_sqlite](http://php.net/manual/en/ref.pdo-sqlite.php)
* [pgsql](http://php.net/manual/en/book.pgsql.php)
* [posix](http://php.net/manual/en/book.posix.php)
* [readline](http://php.net/manual/en/book.readline.php)
* [redis](https://pecl.php.net/package/redis)
* [reflection](http://php.net/manual/en/book.reflection.php)
* server
* [session](http://php.net/manual/en/book.session.php)
* [SimpleXML](http://php.net/manual/en/book.simplexml.php)
* [soap](http://php.net/manual/en/book.soap.php)
* [sockets](http://php.net/manual/en/book.sockets.php)
* [spl](http://php.net/manual/en/book.spl.php)
* [sqlite3](http://php.net/manual/en/book.sqlite.php)
* [stream](http://php.net/manual/en/book.stream.php) ([async streams](/hack/asynchronous-operations/extensions#streams))
* [string](http://php.net/manual/en/book.string.php)
* sysvmsg
* sysvsem
* sysvshm
* [thread](http://php.net/manual/en/class.thread.php)
* thrift_protocol
* [tokenizer](http://php.net/manual/en/book.tokenizer.php)
* [url](http://php.net/manual/en/book.url.php)
* [wddx](http://php.net/manual/en/book.wddx.php)
* xenon
* [xhprof](http://php.net/manual/en/book.xhprof.php)
* [xml](http://php.net/manual/en/book.xml.php)
* [xmlreader](http://php.net/manual/en/book.xmlreader.php)
* [xmlwriter](http://php.net/manual/en/book.xmlwriter.php)
* [xsl](http://php.net/manual/en/book.xsl.php)
* [zip](http://php.net/manual/en/book.zip.php)
* [zlib](http://php.net/manual/en/book.zlib.php)

## 动态加载的扩展

* [dbase](https://github.com/skyfms/hhvm-ext_dbase)
* [geoip](https://github.com/vipsoft/hhvm-ext-geoip)
* [msgpack](https://github.com/reeze/msgpack-hhvm)
* [mongodb](http://github.com/mongodb/mongo-hhvm-driver)：官方 MongoDB 驱动作为 HNI 扩展
* [mongofill](https://github.com/mongofill/mongofill-hhvm)：纯 PHP 中实现传统的 MongoDB 驱动
* [shp](https://github.com/skyfms/hhvm-ext_shape)
* [ssdeep](https://github.com/treffynnon/hhvm-ssdeep)
* [uuid](https://github.com/vipsoft/hhvm-ext-uuid)
* [uv](https://github.com/chobie/hhvm-uv)
* [zmq](https://github.com/Orvid/php-zmq)

### 载入

要载入动态加载的扩展，请遵循该扩展的指示说明。不过，一般情况下是这样的：

```
cd /path/to/extension
hphpize
cmake .
make
```

这将创建一个 `.so` 文件。然后在你的 `.ini` 配置文件中：

```
extension_dir = /etc/hhvm
hhvm.extensions[extension_name] = extension.so
```

或者

```
hhvm.dynamic_extensions[extension_name] = extension.so
```

## 构建自己的扩展

建立你自己的扩展超出了本用户指南的范围，但有一些很好的外部资源可以帮助你开始：

* https://github.com/facebook/hhvm/wiki/Extension-API
* http://blog.golemon.com/2015/01/hhvm-extension-writing-part-i.html

---

> *本节由 [Evilran](https://github.com/Evilran) 翻译*