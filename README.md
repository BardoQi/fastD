#FastD-php-simple-framework for PHP5.4+ 

#version: 1.0.x

**简单**、**高效**、**敏捷**、**灵活**、**组件式更新**

#发起人 
* JanHuang / bboyjanhuang@gmail.com

#维护者
* JanHuang / bboyjanhuang@gmail.com

###简介
满满都是FastD，FastD是你，你是FastD，FastD，让开发充满乐趣。

###特色

	1) 简单 
	2) 灵活 
	3) RESTful路由 
	4) composer安装/管理 
	5) 灵活配置 
	6) 遵循PSR命名规范 
	7) 面向对象 
	8) 命令行
	9) 直观的文件布局

###参考

PSR-*: [http://www.php-fig.org/](http://www.php-fig.org/)

Composer: [http://getcomposer.org/](http://getcomposer.org/)

Git: [http://git-scm.com/book/zh/v1](http://git-scm.com/book/zh/v1)

=========

#＃环境配置

###环境要求

* PHP >= 5.4.*


##如果你觉得安装过于复杂，没关系，我已经打包好了。直接去下载吧。

地址：[https://coding.net/u/janhuang/p/FastD-framework-stable-src/git](https://coding.net/u/janhuang/p/FastD-framework-stable-src/git)

*寻找标签，最新的版本即可。*

=====

&nbsp;

##＃如果一下环境配置过的，请忽略。

*环境配置建议使用 vagrant 进行配置， 也是建议PHP开发人员配备的。*

###安装Composer

`composer` 下载地址: [composer](https://getcomposer.org)

###安装FastD

在安装本框架前需要确保正确安装 `composer` 依赖管理。

`composer create-project janhuang/FastD-php-simple-framework path v1.1.1`

**注意：因为国内访问composer超级缓慢的问题，建议使用代理或者国内镜像进行安装**

===

&nbsp;

###隐藏文件 `(dev|local|prod).php`（优雅链接）

####说明：为神马有三个入口文件

三个文件分别对应：

`dev.php` --->  开发环境，也就是测试环境 加载`config_dev.php`配置文件

`local.php` ->  针对本地环境，开发机 加载`config_local.php`配置文件

`prod.php` ->  针对生产环境， 加载`config_prod.php`配置文件

通过git进行代码管理，可以快速部署应用，将依赖降到最低。不信？你试试看

###Apache

框架通过 `public/.htaccess`文件来实现优雅链接，隐藏 `(dev|local|prod).php`。在访问中不需要带 `(dev|local|prod).php`，但是要确定的是，需要开启 `mod_rewrite` 模块

###Nginx

```
server {
	#setting......
    location / {
            try_files $uri @rewriteapp;
    }
    location @rewriteapp {
            rewrite ^(.*)$ /prod.php$1 last;
    }
    location ~ ^/(dev|local|prod)\.php(/|$) {
    	#setting......
        fastcgi_split_path_info ^(.+.php)(/.*)$; #解析PHP pathinfo
        fastcgi_param PATH_INFO $fastcgi_path_info; #新增PHP pathinfo
    }
}
```

以上是部署生产环境，测试环境需要调整 `prod.php` 文件即可

=====

&nbsp;


#废话不多说，赶紧撸

====

#＃基本功能

	1 路由
	2 事件
	3 Make工具
	

##＃1. 路由

路由足够参考`Laravel`框架，但是不同的，可以配置多个不同项目的路由组，用以区分项目，具体如何做到更好理解和直观，需要你自己手动去明明。路由配置文件详见: `app/routes.php` 和项目路径下 `Resources/config/routes.php`

创建路由方式也很简单，而且分别支持 `GET, POST, PUT, DELETE, HEAD, OPTIONS, ANY`。

创建路由通过 `Routes` 类创建。

###＃Routes API

#####@Route::

###＃路由

####GET

#####`@Routes::get(string|array, callback);`

####@examples:

普通路由：

```
Routes::get('/', function () {
	return 'hello get';
});
```

带有路由名字的路由：

```
Routes::get(['/', 'name' => 'welcome'], function () {
	return 'hello name';
});
```

##如何访问？你他么在逗我。

输入: `http://localhost/path/to/project/public/`

即可输出以上的: `hello name`

为何能够输出 `hello name`

这里的话，因为路由绑定的是一个匿名函数，所以这里直接会触发匿名函数。这里要注意的是，函数体内必需 `return` 相关信息。如果返回的数组，会默认给你返回 `\FastD\Http\JsonResponse` 对象， 如果是字符串，则会返回 `\FastD\Http\Response`

路由资源创建完成后回返回 `\FastD\Routing\RouteInterface` 对象，可以动态配置路由信息

例如：

```
Routes::get('/', function () {})->setName('welcome');
```

&nbsp;

其他路由定义如此类推。请简单看看以下例子：

====

###@Routes::post

#####`@Routes::post(string|array, callback);`

带有访问限制的路由, 只允许 `post` 访问

```
Routes::post(['/post', 'name' => 'post'], function () {
	return 'hello post';
});
```


====

###@Routes::put

#####`@Routes::put(string|array, callback);`

带有访问限制的路由, 只允许 `put` 访问

```
Routes::put(['/put', 'name' => 'put'], function () {
	return 'hello put';
});
```


====

###@Routes::delete

#####`@Routes::delete(string|array, callback);`

带有访问限制的路由, 只允许 `delete` 访问

```
Routes::delete(['/delete', 'name' => 'delete'], function () {
	return 'hello delete';
});
```


====

###@Routes::head

#####`@Routes::head(string|array, callback);`

带有访问限制的路由, 只允许 `head` 访问

```
Routes::post(['/head', 'name' => 'head'], function () {
	return 'hello head';
});
```


====

###@Routes::options

#####`@Routes::options(string|array, callback);`

带有访问限制的路由, 只允许 `options` 访问

```
Routes::post(['/options', 'name' => 'options'], function () {
	return 'hello options';
});
```


====

###@Routes::any

#####`@Routes::any(string|array, callback);`

允许所有访问

```
Routes::post(['/any', 'name' => 'any'], function () {
	return 'hello any';
});
```

====

&nbsp;

##＃2. 事件

        事件。一个不陌生的名词，却也是一个不易理解的名词。在 `javascript` 中事件相信都不陌生，但是在 "世界上最好的语言" `php` 中又是怎么一个概念呢？首先要理解一点很容易的就是，用户的每一个请求，其实就是每一个相同的事件: *请求事件*。 当然可以在这个请求事件中绑定不同的触发器。例如最简单的就是一个简单的MVC框架，可以在每次访问都调用制定的控制器一样，其控制器就是绑定了指定的路由地址，因为用户在访问的时候就出发了那个事件。

在 `FastD php simple framework` 中，已经删除了控制器的概念了，只有事件绑定，当然事件机制目前还不是很完善，可以说甚至还没成型，但是这个是未来方向。框架中约定每个路由绑定一个或者多个事件，在触发事件中可以在绑定指定事件。下列指定一个简单的例子：


====


路由地址：

```
Routes::get('/', function () {
	return 'hello world';
});
```

以上路由 `/` 绑定了一个匿名函数，在用户请求 `/` 路由地址的时候，匿名函数就会触发，执行相应的逻辑。

除了绑定匿名还书，还可以绑定指定的类，执行方法有两种，一个是手动实例化，另外一种是字符串映射。

手动实例化：

```
Routes::get('/', array(new event, handle));
```

手动实例化不能实现依赖注入，需要手动注入。

字符串映射：

```
Routes::get('/', 'Demo\Event@handle');
```

字符串映射，则可以自动注入所需对象。但执行效率会略慢手动。

越特么智能的东西越慢，越烦琐的东西越快。 这句话真对编码


====

##＃3. Make工具

Make工具，用于全局快速，灵活创建和使用对象。没有复杂的工序，简单自由的整合第三方插件，并且自由配置。

其实Make没有那么神。只是在应用初始化的时候加在进去了内存，所以可以全局使用。而且Make工具方法均为静态(static)，所以灵活；因为Make工具只负责中间调度，所以简单。你也可以随心所欲的整合第三方工具包，利用Make作为中间调度层，前提是你做的工具足够灵活配置。。。

Make工具所含API：

&nbsp;

我特么这里就不写了。自己看代码去。路径 `app/kernel/Make.php`。 里面的方法都很简单，一目了然，看不懂的自己面壁去。

====

#＃数据库

数据库，这东西会用的人多，懂的人少，精的人更尼玛少。说多都是泪。

用咱们 `FastD` 去创建数据库连接也很简单，而且支持多库查询哦，么么哒。

===

###1. 使用Make工具创建数据库连接

`Make:db($connection);`

`$connection` 参数需要参考环境配置文件 `config_(dev|local|prod).php` 里面的 `database` 配置项，分别对应链接类型。举个🌰：

配置文件信息：

```
    // setting
'database' => [
        'write' => [
            'database_type'     => 'mysql',
            'database_host'     => 'localhost',
            'database_port'     => 3306,
            'database_user'     => 'root',
            'database_pwd'      => '123456',
            'database_charset'  => 'utf8',
            'database_name'     => 'test',
            'database_prefix'   => ''
        ],
        'read' => [
            'database_type'     => 'mysql',
            'database_host'     => 'localhost',
            'database_port'     => 3306,
            'database_user'     => 'root',
            'database_pwd'      => '123456',
            'database_charset'  => 'utf8',
            'database_name'     => 'test',
            'database_prefix'   => ''
        ],
    ],
    // setting
```

参考上述配置，如果要获取"写"库链接，通过Make工具创建，则需要 `Make::db('write')`，bingo，就这么简单，想链接哪个就链接哪个，哪里不会点哪里了。

====

##2. 查询。

其实这些我都不想说了。太简单的了，都是基本操作，不过还是简单说一下。

####执行查找

#####基础查找

查找一条数据

`find($where = array(), [$fields = '*'])`

查找所有数据

`findAll($where = array(), [$fields = '*'])`

根据条件查找一条数据

`findBy($where = array(), [$fields = '*'])`

根据条件查找所有数据

`findAllBy($where = array(), [$fields = '*'])`

灵活根据条件查找一条数据

`findBy字段名($where = array(), [$fields = '*'])` 如：`findById(1) => findBy(array('id' => 1))`

灵活根据条件查找所有数据

`findBy字段名($where = array(), [$fields = '*'])`

如： 

`findAllByTitle('hello') => findAllBy(array('title' => 'hello'));`
`findAllByCatId(1) => findAllBy(array('cat_id' => 1));`

#####基础业务操作

插入

`insert($datas = array());`

更新

`update($where = array(), $datas = array())`

删除,这里删除数据不允许删除整个表数据，只允许删除符合条件的数据，这里条件参数比传

`delete($where = array());`

####字定义数据查询

这里数据查询返回的是一个二维数组

`createQuery($dql);`

`getQuery()`

`getResult()`

如：

`$connection->createQuery('sql')->getQuery()->getResult()`

&nbsp;

以上所有查询结果返回的是 `\FastD\Database\Result\ResultCollection` 对象，实现 `AccessArray, Iterator` 接口，可格式化，通过 `toArray, toJson, toObject...` 等进行格式化

##3. 模型库 Repository

创建数据库连接后，可以通过 `getRepository` 进行获取模型库，模型库默认按照类名进行数据表映射。比如 `PostRepository` => prefix_post。 数据库名一律小写。

其他方法跟上述一样，详细请自行研究，整体不复杂，基于 `medoo` 进行整合。

写文档真尼玛累。

====

#＃key/value存储

##1. 创建链接

根据配置文件配置

```
 // 存储配置
    'storage' => [
        'write' => [
            'type' => 'redis',
            'host' => '11.11.11.11',
            'port' => 6379
        ],
    ],
```

通过Make工具创建。 `Make::storage('write')` 即可自行链接

类型指定通过 `type` 字段指定。 目前支持 `redis, memcache, memcached, ssdb`。 `disque` 暂时不支持

===

#＃Template模板引擎

模板引擎默认使用twig，目前也只整合twig模板引擎

通过 `Make::render($template, array $paramters = array())` 模板路径在 `app/views` 和 `src`所有目录下，渲染模板需要完整路径。具体使用可以参考twig模板引擎。

模板引擎配置通过 `config` 下面的template进行配置。默认配置项请看配置文件

===

#＃辅助类 helpers

通过 `Make::helpers()` 创建。支持依赖注入哦，么么哒。其他动态参数需要在创建的时候进行手动注入。

添加辅助类。

通过 `Application::registerHelpers` 方法进行注册。可以使用类完整类名进行注册，也可以直接实例化注册，反正写进去就行了。

*记得写下辅助类的名字，方便获取*

#####@example

```
public function registerHelpers()
    {
        return array(
            'demo' => 'Helpers\\Demo\\Demo'
        );
    }
```

键名就是辅助类的别名了。直接通过 `Make::helpers('demo')` 获取

## 感受

文档写的很累啊。尼玛，基本功能以上了。还有更多丰富的。唉，尼玛好多啊，要写到啥时候。。。。。。先不写了，你们补充。

====

#Author

*Name*:  **[JanHuang](http://segmentfault.com/blog/janhuang)**

*Blog*: **[http://segmentfault.com/blog/janhuang](http://segmentfault.com/blog/janhuang)**

*EMail*:  **bboyjanhuang@gmail.com**

====

#License MIT


