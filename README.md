#Mysql 中文全文索引 案例

配置数据库连接的基本信息

在FindFullText.class.php类中：

       'mysql:host=localhost;dbname=blog;charset=utf8';
        $usr = 'root';
        $pwd = '123456';
        $this->db = new PDO($dsn, $usr, $pwd);

数据库建表：

data_text:

          CREATE TABLE `data_text` (
          `uuid` char(255) DEFAULT NULL,
          `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
          `title` varchar(255) DEFAULT NULL,
          `body` longtext,
          `author` varchar(255) DEFAULT NULL,
          `time` datetime DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

index_text:

        CREATE TABLE `index_text` (
          `uuid` varchar(255) DEFAULT NULL,
          `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `title` varchar(200) DEFAULT NULL,
          `body` longtext,
          PRIMARY KEY (`id`),
          FULLTEXT KEY `title` (`title`,`body`)
        ) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

## FindFullText.class.php类中方法介绍： ##

get_fenci()//获取文章段落的中文分词结果

    //这里调用分词类
    public function get_fenci($teststr)
    {
        //PhpAnalysis::$loadInit = false;
        $pa = new PhpAnalysis('utf-8', 'utf-8', true);
        //执行分词
        $pa->SetSource($teststr);
        //多元切分
        $pa->differMax = true;
        //新词识别
        $pa->unitWord = true;
        //歧义处理
        $pa->StartAnalysis(true);
        //输出结果
        return $pa->GetFinallyResult(' ', false);
    }    


get_uuid()//获取唯一UUID

    
    public function get_uuid($prefix = '')
    {
        $chars = md5(uniqid(mt_rand(), true));
        $uuid = substr($chars, 0, 8);
        $uuid .= substr($chars, 8, 4);
        $uuid .= substr($chars, 12, 4);
        $uuid .= substr($chars, 16, 4);
        $uuid .= substr($chars, 20, 12);
        return $prefix . $uuid;
    }

add($title,$body)//向数据库添加信息，传入文章标题和文章内容

    public function add($title, $body)
    {
        $author = 'root';
        $uuid = $this->get_uuid();
        $today = date("Y-m-d H:i:s");
        $sql = 'INSERT INTO data_text ' . '(uuid,title, body, author, time) ' . 'values ' . "('$uuid','$title', '$body', '$author', '$today')";
        //echo $sql;
        $this->db->exec($sql);
        $index_title = $this->get_fenci($title);
        $index_body = $this->get_fenci($body);
        $sql_index = 'INSERT INTO index_text ' . '(uuid,title, body) ' . 'values ' . "('$uuid','$index_title', '$index_body')";
        $count = $this->db->exec($sql_index);
        return $count;
    }

search($word)//全文检索功能，传入要搜索的关键字

    public function search($word)
    {
        $word = $this->get_fenci($word);
        $sql = "SELECT A.title, A.body,A.id, author, time 
           FROM data_text as A,index_text as B 
           WHERE A.uuid = B.uuid
        AND MATCH (B.title, B.body) AGAINST ('".$word."')";
        $sth = $this->db->query($sql);
        $result = $sth->fetchALL(PDO::FETCH_ASSOC);
        return $result;
    }


