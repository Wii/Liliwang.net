<?php
/**
 * ʵ����ʼ
 */
// �ִʽ��֮�ص����� (param: �ֺõĴ���ɵ�����)
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

// ʵ����ǰ�Ĳ���ָ�����ȡ
$dict = 'dict/dict.xdb';	// Ĭ�ϲ��� xdb (���������κ�����)
$mydata  = NULL;	// ��������
$version = 3;		// ���ð汾
$autodis = true;	// �Ƿ�ʶ������
$ignore  = true;	// �Ƿ���Ա��

$sample_text = <<<__EOF__
�˴�����ؼ���
__EOF__;

	// �з�����
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

// ������� \r\n\t
if (!is_null($mydata)) 
	$mydata = trim($mydata);

// ʵ�����ִʶ���(mydata�ǿ�)
$object = 'PSCWS' . $version;
require (strtolower($object) . '.class.php');
	
$cws = new $object($dict);
$cws->set_ignore_mark($ignore);
$cws->set_autodis($autodis);

?>
<html>
<head>
<title>Task II ����ĿIIʵ��</title>
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
            //��������
            var options = new google.search.SearcherOptions();
            //���������Ϊ��ʱ��ʾ����
            options.setNoResultsString('��ѯ���Ϊ�գ�');
 
            //�����ؼ�ʵ����
            var searchControl = new google.search.SearchControl();
            //ÿ����ʾ8�����������ȡֵ��Χ��1-8��
            searchControl.setResultSetSize(3);
              
            //ȫ������
            searchControl.addSearcher(new google.search.WebSearch(), options);
  
            //�����Ƶ����
            searchControl.addSearcher(new google.search.VideoSearch(), options);
 
            //�����������
            searchControl.addSearcher(new google.search.NewsSearch(), options);
 
            //���ͼƬ����
            searchControl.addSearcher(new google.search.ImageSearch(), options);
 
            //��ӱ��ص�ͼ����
            var localSearch = new google.search.LocalSearch();

            //��ͼ���ı�� ����ʱ��ʹ�á���������
            localSearch.setCenterPoint("����,��¥");
            searchControl.addSearcher(localSearch, options);
 
            //��������
            var drawOptions = new google.search.DrawOptions();
            drawOptions.setDrawMode(google.search.SearchControl.DRAW_MODE_TABBED);
            searchControl.draw(document.getElementById("searchcontrol"), drawOptions);
 
            //ִ��������ѯ
            searchControl.execute("google api");
        }
 
        //��ܼ�����ɺ����
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
  <font color=red>Task II ����ĿIIʵ��</font>
</h3>  

<table width=100% border=0>
  <tr>
    <form method=post>
	<td width=100%>
	  <strong>���������ֵ���ύ���Էִ�: </strong> <br />
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
        <strong>�ִʽ��(ԭ���ܳ��� <?php echo strlen($mydata); ?> �ַ�) </strong><br />
        <textarea cols=60 rows=8 class=demotx readonly style="color:#888888;">

<?php
// ִ���з�, �ִʽ������ִ�� words_cb()
$cws->segment($mydata, 'words_cb');
// ������ʾ���
?>
         </textarea>		
     </td>
  </tr>
</table>

<pre>
<?php echo "�������<br/>";?>
</pre>
<div id="searchcontrol">
        ������...
    </div>

</body>
</html>
