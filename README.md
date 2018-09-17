精简,高效的 PHP API开发框架 (简单业务简单实现，复杂业务自由实现)

------


<h3>效果演示</h3>

------

```
{
    "code": 2000,
    "info": "返回成功",
    "data": {
        "id": "25",
        "isbn": "9787115275790",
        "openid": "oHoYY49saI93BkrPwH8c5mMJpbuU",
        "title": "JavaScript高级程序设计（第3版）",
        "image": "https://img3.doubanio.com/view/subject/m/public/s8958650.jpg",
        "alt": "https://book.douban.com/subject/10546125/",
        "publisher": "人民邮电出版社",
        "summary": "内容",
        "price": "99.00元",
        "rate": "9.3",
        "tags": "JavaScript 2175,Web前端开发 991,前端开发 609,前端 462,javascript 461,编程 409",
        "author": "[美] Nicholas C. Zakas",
        "count": "1"
    }
}
```

说明：Lessapi 同样支持视图层，模板引擎，但考虑到更侧重于api实现，所以不需要的话，
可以在composer文件中移除即可smarty/smarty即可，如果有需要，请参考smarty3.0语法，
无需更多学习成本，快速上手。

框架内附 操作 DOME,  你会发现html中 调用变量输出改成了 <{$data.title}>，多了两个尖括号，
是因为考虑到一些冲突问题，我们将定界符稍有修改.

------

<h4>开发文档</h4>

https://www.showdoc.cc/lessapi
 
技术群：499125737

期待更多开源热爱者加入 

（〜^㉨^)〜  ლ(^o^ლ)　