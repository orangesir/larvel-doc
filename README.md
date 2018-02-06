# larvel接口文档生成,测试工具生成工具
> 目前完成了文档生成部分


# demo(controller中)：
> 基本文档模板(后续会写详细文档）
<pre>
    /**
     * @Name 用户中心-登录
     * @Description 用户登录接口
     * @Param username:"登录邮箱",
     * @Param password: "登录密码"
     *
     * @Response 通用格式:{"code":响应码,"message":"错误描述","data":{}}
     * data{
     *    userid:"用户id，值为0表示用户未登录",
     *    nickname: "用户昵称",
     *    expired: 最后有效时间（时间戳秒）,-1
     * }
     */
     public function login(Request $request)
</pre>

# 基本使用方法
1. composer 安装包:
  > composer require --dev orangesir/larvel-doc:dev-master
2. 配置服务提供者, config/app.php
  > 'providers' => [ Apidoc\ApiDocServiceProvider::class ]
3. 生成文档:
  php artisan doc:generate
4. 查看文档: http://project-domain/docs/index.html