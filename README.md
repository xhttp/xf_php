xf_php
======
这是一个简单的，轻量级的 php 开发框架，采用 MVC 开发模式。

数据库访问采用 PDO，可以配置多个主从分离的 MySQL 数据库

模板引擎 Smarty，也可以采用原生的 php 内嵌方式

调用的方式为： http://www.domain.com/index/index

index 为默认的模块名和方法名，可以省略

第一个 index 为模块 module 第二个 index 为动作 action

框架目录结构： xf_php

|-- application<br>
    |-- cache 
    |-- config
        |-- config.php
    |-- controller
        |-- IndexController.php
    |-- view
        |-- index
            |-- index.html
    |-- viewc
|-- libraray
    |-- smarty 
    |-- session.php
|-- www
    |-- css 
    |-- js 
    |-- index.php
|-- xfphp
    |-- XF_Application.php 
    |-- XF_Cache.php 
    |-- XF_Controller.php 
    |-- XF_Database.php 
    |-- XF_Exception.php 
    |-- XF_Factory.php 
    |-- XF_Http.php 
    |-- XF_Page.php 
    |-- XF_Request.php 
    |-- XF_Response.php 
    |-- XF_Router.php 
    |-- XF_Util.php


－－－－－末完待续
