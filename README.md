### 所需环境
    php + mysql
### 扩展无

### 如果是nginx
    增加一条url重写小模块
    location /
    {
        try_files $uri $uri/ /index.php?$query_string;
    }