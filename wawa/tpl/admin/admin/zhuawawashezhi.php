<?php if( !defined( 'ONGPHP')) exit( 'Error ONGSOFT');
$shezhi = $Mem1->g('shezhi');
// echo "<pre>";
// var_dump( $shezhi );
// echo "</pre>";



?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>设置</title>
	<script type="text/javascript" src="/jquery-2.1.1.js"></script>
	<link rel="stylesheet" type="text/css" href="/layui/css/layui.css">
	<script type="text/javascript" src="/layui/layui.js" ></script>
	<link rel="stylesheet" type="text/css" href="/webuploader/webuploader.css">

<!--引入JS-->
<script type="text/javascript" src="/webuploader/webuploader.js"></script>
</head>
<body>






<div style="padding: 20px">
	

<!-- <span class="layui-btn layui-btn-normal  addxuanxiang">
	增加选项
</span> -->






	<form class="layui-form" action=""  id="bbb" >
	<div id="cha">


		<div class="layui-form-item layui-form-text">

		<label class="layui-form-label" style="width: 200px">【微信设置】</label>  
		<div class="layui-form-mid layui-word-aux">【AppID】</div>
		<div class="layui-input-inline" style="width: 600px;" > 

		<input  type="text" name="data[appid]" required="" lay-verify="required" placeholder="请输入值" autocomplete="off" class="layui-input" value="<?php echo $shezhi['appid'] ?>"> 

		</div> 

		<div class="layui-form-mid layui-word-aux">【AppSecret】</div>

		<div class="layui-input-inline" style="width: 600px;"> 

		<input  type="text" name="data[appsecret]"  required="" lay-verify="required" placeholder="请输入值" autocomplete="off" class="layui-input" value="<?php echo $shezhi['appsecret'] ?>"> 
		</div>
		

		</div>




		<div class="layui-form-item">

		<label class="layui-form-label" style="width: 200px">【5元奖池】</label>  
<div class="layui-form-mid layui-word-aux">【首次】</div>
		<div class="layui-input-inline" style="width: 600px;" > 

		<input  type="text" name="data[5yuan]" required="" lay-verify="required" placeholder="请输入值" autocomplete="off" class="layui-input" value="<?php echo $shezhi['5yuan'] ?>"> 

		</div> 



		<div class="layui-form-mid layui-word-aux">【2次】</div>

		<div class="layui-input-inline" style="width: 600px;"> 

		<input  type="text" name="data[5yuan2]"  required="" lay-verify="required" placeholder="请输入值" autocomplete="off" class="layui-input" value="<?php echo $shezhi['5yuan2'] ?>"> 
		</div>
		

		</div>

		


		<div class="layui-form-item">
		<label class="layui-form-label" style="width: 200px"> 【10元奖池】</label>  

<div class="layui-form-mid layui-word-aux">【首次】</div>

		<div class="layui-input-inline" style="width: 600px"> 

		<input  type="text" name="data[10yuan]" required="" lay-verify="required" placeholder="请输入值" autocomplete="off" class="layui-input" value="<?php echo $shezhi['10yuan'] ?>"> 


		</div> 

<div class="layui-form-mid layui-word-aux">【2次】</div>

		<div class="layui-input-inline" style="width: 600px"> 

		<input  type="text" name="data[10yuan2]" required="" lay-verify="required" placeholder="请输入值" autocomplete="off" class="layui-input" value="<?php echo $shezhi['10yuan2'] ?>"> 
		</div>


		</div>


		<div class="layui-form-item">
		<label class="layui-form-label" style="width: 200px">【20元奖池】</label>  


		<div class="layui-form-mid layui-word-aux">【首次】</div>
		<div class="layui-input-inline" style="width: 600px"> 

		<input style="width: 600px" type="text" name="data[20yuan]" required="" lay-verify="required" placeholder="请输入值" autocomplete="off" class="layui-input" value="<?php echo $shezhi['20yuan'] ?>"> 


		</div> 

		<div class="layui-form-mid layui-word-aux">【2次】</div>
		<div class="layui-input-inline" style="width: 600px"> 

		<input  type="text" name="data[20yuan2]" required="" lay-verify="required" placeholder="请输入值" autocomplete="off" class="layui-input" value="<?php echo $shezhi['20yuan2'] ?>"> 

		</div>

		</div>

		<div class="layui-form-item">
		<label class="layui-form-label" style="width: 200px">
			【网站标题】

		</label>  

		<div class="layui-input-inline" style="width: 1000px"> 

		<input  type="text" name="data[title]" required="" lay-verify="required" placeholder="请输入值" autocomplete="off" class="layui-input" value="<?php echo $shezhi['title'] ?>"> 


		</div> 
		</div>

		<div class="layui-form-item">
		<label class="layui-form-label" style="width: 200px">
			【滚动广告】

		</label>  

		<div class="layui-input-inline" style="width: 1000px"> 

		<input  type="text" name="data[ads]" required="" lay-verify="required" placeholder="请输入值" autocomplete="off" class="layui-input" value="<?php echo $shezhi['ads'] ?>"> 


		</div> 
		</div>


		<div class="layui-form-item">
		<label class="layui-form-label" style="width: 200px">
			【三级分销】

		</label>  



		<div class="layui-form-mid layui-word-aux">1级分销得 </div>

			<div class="layui-input-inline">

            <input type="text" name="data[1ji]" required="" value="<?php echo $shezhi['1ji'] ?>" lay-verify="required" placeholder="" autocomplete="off" class="layui-input">



          </div>
			

					<div class="layui-form-mid layui-word-aux">%   <span>-----</span>2级分销得</div>

			<div class="layui-input-inline">

            <input type="text" name="data[2ji]" required="" lay-verify="required" placeholder="" value="<?php echo $shezhi['2ji'] ?>" autocomplete="off" class="layui-input">


          </div>

          <div class="layui-form-mid layui-word-aux">%   <span>-----</span> 3级分销得</div>

			<div class="layui-input-inline">

            <input type="text" name="data[3ji]" required="" lay-verify="required" placeholder="" value="<?php echo $shezhi['3ji'] ?>" autocomplete="off" class="layui-input">



          </div>
		 <div class="layui-form-mid layui-word-aux">%   <span></span> </div>	
	
		</div>


		<!-- <div class="layui-form-item">
		<label class="layui-form-label" style="width: 200px">
			【佣金比例】

		</label>  



          <div class="layui-form-mid layui-word-aux">现金/佣金</div>

			<div class="layui-input-inline">

            <input type="text" name="data[bili]" required="" lay-verify="required" placeholder="" value="<?php echo $shezhi['bili'] ?>" autocomplete="off" class="layui-input">



          </div>
		



	
		</div> -->








		 <div class="layui-form-item">
		<label class="layui-form-label" style="width: 200px">
			【佣金规则】



		</label>  

		<div class="layui-input-inline" style="width: 1000px" id="jkjk"> 



		

		<?php 
			
		

			if (is_array($shezhi['guize'])) {

				foreach($shezhi['guize'] as  $k => $v){
					?>
<div>
	<input type="text" name="data[guize][]" required="" lay-verify="required" placeholder="请输入值" autocomplete="off" class="layui-input" value="<?php echo $v ?>" style="display: inline;width: 90%">  <div style="display: inline;" class="shanchu">
	删除
</div>
</div>

					<?php
				}


			}

		?>





		</div> 

		<style type="text/css">
			.shanchu{
				cursor: pointer;
			}
		</style>

<script type="text/javascript">
jQuery(function(){
	jQuery(".shanchu").click(function(){
		if (!confirm('确认删除吗？')) {
			return false;
		}

		jQuery(this).parent().remove();

	})
});
</script>

		<div class="layui-input-inline">
			
<span style="float: right;" class="layui-btn tianjiaguize">增加规则</span>

		</div>
		</div>


  <!-- <div class="layui-form-item layui-form-text">
    <label class="layui-form-label">客服图片</label>
    <div class="layui-input-block">

            <input type="text" name="data[tupian]" required="" lay-verify="required" placeholder="" value="<?php echo $shezhi['tupian'] ?>" autocomplete="off" class="layui-input">



          </div>
  </div> -->




<div class="layui-form-item">
		<label class="layui-form-label" style="width: 200px">
			【客服图片】

		</label>  

			<div class="layui-input-inline">
				

				<div id="uploader-demo">
    <!--用来存放item-->
    <div id="fileList" class="uploader-list"></div>
    <div id="filePicker">选择图片</div>
</div>



<div class="tpul">  

<?php 
	if ($shezhi['kefu']) {
		?>

		<li><img style="width:100px;height:100px" src="<?php echo $shezhi['kefu'] ?>" alt=""><input type="hidden" name="data[kefu]" value="<?php echo $shezhi['kefu'] ?>" /> </li>
		<?php
	}
?>

 </div>


			</div>
		
	
		</div>


		<div class="layui-form-item">
		<label class="layui-form-label" style="width: 200px">
			【是否wap端】

		</label>  

			<div class="layui-input-inline">
				
			



            <input type="checkbox" name="data[iswap]" lay-skin="switch"

            <?php 
            if ($shezhi['iswap']=='1') {
            	?>
            	  checked=""
            	<?php
            }

             ?>
           

             lay-text="ON|OFF" lay-filter="switchTest" value="1">


            <div class="layui-unselect layui-form-switch "  lay-skin="_switch"><em>OFF</em><i></i>


            </div>
          


			</div>
		



	
		</div>


		<div class="layui-form-item">
		<label class="layui-form-label" style="width: 200px">
			【背景音乐】

		</label>  

			<div class="">
				

		

			<div class="">
            <input type="checkbox" name="data[isyinyue]" lay-skin="switch"

            <?php 
            if ($shezhi['isyinyue']=='1') {
            	?>
            	  checked=""
            	<?php
            }

             ?>
           

             lay-text="ON|OFF" lay-filter="switchTest" value="1">


            <div class="layui-unselect layui-form-switch "  lay-skin="_switch"><em>OFF</em><i></i>


            </div>





            <div class="" style="display: inline;" >



      <input type="radio" name="data[yinyue]" value="song.mp3" title="音乐1"

      <?php 

      if ( $shezhi['yinyue']=='song.mp3' ) {
      	?>
      	checked=''
      	<?php
      }
       ?>

       ><div class="layui-unselect layui-form-radio layui-form-radioed"><i class="layui-anim layui-icon"></i><span>音乐1</span></div>


      <input type="radio" name="data[yinyue]" value="song1.mp3" title="音乐2"   <?php 

      if ( $shezhi['yinyue']=='song1.mp3' ) {
      	?>
      	checked=''
      	<?php
      }
       ?>>

      <div class="layui-unselect layui-form-radio"><i class="layui-anim layui-icon"></i><span>音乐2</span></div>


    </div>


          </div>

			</div>
		



	
		</div>



	</div>




	  
	  <div class="layui-form-item">
	    <div class="layui-input-block">
	      <button class="layui-btn" lay-submit lay-filter="formDemo" id="lijitijiao">立即提交</button>
	      <!-- <button type="reset" class="layui-btn layui-btn-primary">重置</button> -->
	    </div>
	  </div>
	</form>
	 
	


</div>
<!-- <script type="text/javascript">
jQuery(function(){
	jQuery(".addxuanxiang").click(function(){
		jQuery("#cha").append('<div class="layui-form-item"><label class="layui-form-label"></label> <div class=" qianmian layui-input-inline"> <input type="text" name="text" required="" lay-verify="required" placeholder="请输入设置名称" autocomplete="off" class="layui-input"> </div> <div class="layui-input-inline"> <input style="width: 600px" type="text" name="text" required="" lay-verify="required" placeholder="请输入值" autocomplete="off" class="layui-input"> </div> </div>');
	})


	jQuery("body").delegate('.qianmian','blur',function(){
		var zhi = jQuery(this).find('input').val();
		var  hou = jQuery(this).next().find('input').attr('name',);



		// jQuery(this).next().attr('name',);
	})

});
</script> -->

<script type="text/javascript">
jQuery(function(){


	/*增加规则*/

	jQuery(".tianjiaguize").click(function(){
		jQuery("#jkjk").append('<input type="text" name="data[guize][]" required="" lay-verify="required" placeholder="请输入值" autocomplete="off" class="layui-input" value="">');

	})



	jQuery("#lijitijiao").click(function(){
		var data = jQuery("#bbb").serialize();
		data = data+'&action=shezhiwawa';
		$.ajax({

			async: true,
			type:"POST",
			url:"?action=ajax",
			data:data,
			dataType:'json',
			success:function(data){
				if (data.o=='yes') {
					alert('更新成功');
					location.reload(true);
				}
				
			}
		})


		return false;
	})
});
</script>

<script type="text/javascript">
	

   // 初始化Web Uploader
    var uploader = WebUploader.create({
        // 选完文件后，是否自动上传。
        auto: true,
            fileVal: 'all',
        // swf文件路径
        swf:   'http://cdn.staticfile.org/webuploader/0.1.0/Uploader.swf',
        // 文件接收服务端。
        server: '<?php  echo '?action=ajax&upload=yes&uplx=all'?>',

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#filePicker',

        // 只允许选择图片文件。
        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/jpg,image/jpeg,image/png'
        }
    });

    // 文件上传成功，给item添加成功class, 用样式标记上传成功。
    uploader.on( 'uploadSuccess', function( file,respond ) {
        var tupian = respond.url;
        jQuery(".tpul").html('');

        jQuery(".tpul").append('<li><img style="width:100px;height:100px" src="'+tupian+'" alt=""><input type="hidden" name="data[kefu]" value="'+tupian+'" /> </li>');
    });

</script>

<script>
//Demo
layui.use('form', function(){
  var form = layui.form();
  
  //监听提交
  form.on('submit(formDemo)', function(data){
    layer.msg(JSON.stringify(data.field));
    return false;
  });
});
</script>

</body>
</html>


