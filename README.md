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
　　|-- cache <br>
　　|-- config<br>
　　　　|-- config.php<br>
　　|-- controller<br>
　　　　|-- IndexController.php<br>
　　|-- view<br>
　　　　|-- index<br>
　　　　　　|-- index.html<br>
　　|-- viewc<br>
|-- libraray<br>
　　|-- smarty <br>
　　|-- session.php<br>
|-- www<br>
　　|-- css <br>
　　|-- js <br>
　　|-- index.php<br>
|-- xfphp<br>
　　|-- XF_Application.php <br>
　　|-- XF_Cache.php <br>
　　|-- XF_Controller.php <br>
　　|-- XF_Database.php <br>
　　|-- XF_Exception.php <br>
　　|-- XF_Factory.php <br>
　　|-- XF_Http.php <br>
　　|-- XF_Page.php <br>
　　|-- XF_Request.php <br>
　　|-- XF_Response.php <br>
　　|-- XF_Router.php <br>
　　|-- XF_Util.php<br>


－－－－－末完待续
