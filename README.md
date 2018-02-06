# larvel接口文档生成,测试工具生成工具
> 目前完成了文档生辰部分

# 基本使用方法
1. composer 安装包:
> composer require --dev orangesir/larvel-doc:dev-master
2. 配置服务提供者, config/app.php
> 'providers' => [ Apidoc\ApiDocServiceProvider::class ]
3. 生成文档:
php artisan doc:generate
4. 查看文档: http://project-domain/docs/index.html