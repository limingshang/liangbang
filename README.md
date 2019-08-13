### 所需环境
    php + mysql
### 如果是nginx
    增加一条url重写小模块
    location /
    {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
### 部署完毕记得修改项目目录
    runtime/      读写权限