<?php
/**
 * Created by PhpStorm.
 * User: 张鹏翼
 * Date: 2016/8/10
 * Time: 10:28
 */
require_once './php/fenci/phpanalysis.class.php';
date_default_timezone_set('UTC');


class FindFullText
{
    public $db;

    /**
     * FindFullText constructor.
     */
    public function __construct()
    {
        $dsn = 'mysql:host=localhost;dbname=blog;charset=utf8';
        $usr = 'root';
        $pwd = '123456';
        $this->db = new PDO($dsn, $usr, $pwd);
        $this->db->query("set character set 'utf8'");
    }

    /**
     * @param $teststr
     * @return string
     */
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
    public function select(){
        $sql = "SELECT * FROM data_text";
        $sth = $this->db->query($sql);
        $result = $sth->fetchALL(PDO::FETCH_ASSOC);
        return $result;
    }
    public function selectOne($id){
        $dbName = 'data_text';
        $sql = "SELECT * FROM ".$dbName." WHERE id=".$id;
        $sth = $this->db->query($sql);
        $result = $sth->fetchALL(PDO::FETCH_ASSOC);
        return $result;

    }
}




