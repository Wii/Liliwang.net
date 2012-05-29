<?php
/**
 * 实例开始
 */
// 分词结果之回调函数 (param: 分好的词组成的数组)
function words_cb($ar)
{
	foreach ($ar as $tmp)
	{
		if ($tmp == "\n")
		{
			echo $tmp;
			continue;
		}
		echo $tmp . ' ';
	}
	flush();
}

// 实例化前的参数指定与读取
$dict = 'dict/dict.xdb';	// 默认采用 xdb (不需其它任何依赖)
$mydata  = NULL;	// 待切数据
$version = 3;		// 采用版本
$autodis = true;	// 是否识别名字
$ignore  = true;	// 是否忽略标点

$sample_text = <<<__EOF__
此处键入关键字
__EOF__;

	// 切分数据
	if (!isset($_REQUEST['mydata']) || empty($_REQUEST['mydata']))
	{
		$mydata = $sample_text;
	}
	else
	{
		$mydata = & $_REQUEST['mydata'];
		if (get_magic_quotes_gpc())
			$mydata = stripslashes($mydata);
	}

// 清除最后的 \r\n\t
if (!is_null($mydata)) 
	$mydata = trim($mydata);

// 实例化分词对像(mydata非空)
$object = 'PSCWS' . $version;
require (strtolower($object) . '.class.php');
	
$cws = new $object($dict);
$cws->set_ignore_mark($ignore);
$cws->set_autodis($autodis);

?>
<html>
<head>
<title>Task II 软工项目II实现</title>
<meta http-equiv="Content-type" content="text/html; charset=gbk">

<style type="text/css">
        #searchcontrol .gsc-control
        {
            width: 100%;
        }
        #searchcontrol .gsc-result-cnblogs .gs-title
        {
            color:Red;
        }
</style>
<script src="https://www.google.com/jsapi?key=ABQIAAAAWUT8aaIj9mtqQa087LjVOhTPB5B7LRDljl2Cr4-JwBNft1mFrRRmR1RoYEUCZCj0dtS2gIc8Al4-VA" type="text/javascript"></script>
<script language="Javascript" type="text/javascript">
        google.load("search", "1");
 
        function OnLoad() {
            //搜索设置
            var options = new google.search.SearcherOptions();
            //当搜索结果为空时显示内容
            options.setNoResultsString('查询结果为空！');
 
            //搜索控件实例化
            var searchControl = new google.search.SearchControl();
            //每次显示8个搜索结果（取值范围：1-8）
            searchControl.setResultSetSize(3);
              
            //全网搜索
            searchControl.addSearcher(new google.search.WebSearch(), options);
  
            //添加视频搜索
            searchControl.addSearcher(new google.search.VideoSearch(), options);
 
            //添加新闻搜索
            searchControl.addSearcher(new google.search.NewsSearch(), options);
 
            //添加图片搜索
            searchControl.addSearcher(new google.search.ImageSearch(), options);
 
            //添加本地地图搜索
            var localSearch = new google.search.LocalSearch();

            //地图中心标记 测试时可使用“大雁塔”
            localSearch.setCenterPoint("西安,钟楼");
            searchControl.addSearcher(localSearch, options);
 
            //绘制搜索
            var drawOptions = new google.search.DrawOptions();
            drawOptions.setDrawMode(google.search.SearchControl.DRAW_MODE_TABBED);
            searchControl.draw(document.getElementById("searchcontrol"), drawOptions);
 
            //执行搜索查询
            searchControl.execute("google api");
        }
 
        //框架加载完成后调用
        google.setOnLoadCallback(OnLoad);
</script>

<style type="text/css">
<!--
td, body	{ background-color: #efefef; font-family: tahoma; font-size: 14px; }
.demotx		{ font-size: 12px; width: 100%; height: 100px; }
small		{ font-size: 12px; }
//-->
</style>
</head>
<body>
<h3>
  <font color=red>Task II 软工项目II实现</font>
</h3>  

<table width=100% border=0>
  <tr>
    <form method=post>
	<td width=100%>
	  <strong>请输入文字点击提交尝试分词: </strong> <br />
	  <textarea name=mydata cols=60 rows=8 class=demotx><?php echo $mydata; ?></textarea>
	  <input type=submit>
	</td>
    </form>
  </tr>
  <tr>
    <td><hr /></td>
  </tr>
  <tr>
     <td width=100%>
        <strong>分词结果(原文总长度 <?php echo strlen($mydata); ?> 字符) </strong><br />
        <textarea cols=60 rows=8 class=demotx readonly style="color:#888888;">

<?php
// 执行切分, 分词结果数组执行 words_cb()
$cws->segment($mydata, 'words_cb');
// 以下显示结果
?>
         </textarea>		
     </td>
  </tr>
</table>

<pre>
<?php echo "搜索结果<br/>";?>
</pre>
<div id="searchcontrol">
        加载中...
    </div>

</body>
</html>
