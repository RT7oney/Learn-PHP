<?php if( !defined( 'ONGPHP')) exit( 'Error ONGSOFT');?>
<footer class="footer mt-20">
	<div class="container">
		<p>
		Copyright <?php echo $CONN['title'];?> by <?php echo SOFTNAME;?>
		</p>
	</div>
</footer>

<script>

function suijishu(){

    return  Date.parse(new Date()) / 1000+''+Math.floor(Math.random()*10000+1);
}


var updatedurl='<?php echo $_SERVER['SCRIPT_NAME'];?>?action=<?php echo $AC;?>&mode=edit&uplx=image&dir=image';

function zengjia( id , k , caidan ){

          if(typeof i === 'undefined') i= 1;
         
          i = i+1;

          html = '<div id="d'+id+i+'" data="'+id+'" style="margin-top:5px;">';

          fass =  caidan.split(',');
          

            for(var w in fass){


                if(fass[w].indexOf( 'update-') > -1 ){

                    tazhi =w+'a'+(i+100)+'b';

                    html +=fass[w]+':<input type="text" class="input-text" style="width:208px;margin-right:2px;"  value="" id="imgshowac'+tazhi+'"  placeholder="" name="'+k+'['+(i+100)+']['+( fass[w] )+']" > <input type="button" id="filePicker'+tazhi+'"  value="update"  /><script>KindEditor.ready(function(K) {    var uploadbuttonac'+tazhi+' = K.uploadbutton({  button : K("#filePicker'+tazhi+'")[0], fieldName : "all",  url : "<?php echo $_SERVER['SCRIPT_NAME']."?action=".$_GET['action'];?>&mode=edit&uplx=all",afterUpload : function(data) { if ( data.error === 0) {var url = K.formatUrl(data.url, "absolute");  K("#imgshowac'+tazhi+'").val(url);}else{  layer.msg(data.message, { time: 2000 });}}, afterError : function( str ) {layer.msg(str, { time: 2000,  }); }});uploadbuttonac'+tazhi+'.fileBox.change(function(e) {uploadbuttonac'+tazhi+'.submit();}); });<\/script>';

                }else{

                    html +=fass[w]+': <input type="text" class="input-text" style="width:208px;margin-right:2px;" name="'+k+'['+(i+100)+']['+( fass[w] )+']" value="">';

                }

           
           }

        html += '<a style="color:Red;" href="javascript:shanchuduo(\''+'d'+id+i+'\')"> <i class="Hui-iconfont"  style="color:red;">&#xe6a1;</i> </a></div>';



        $(".qujicplist"+id). append( html );


}



function shanchuduo( id ){


          
         

          var tname = $("#"+id).attr('data');
           $("#"+id).remove();


          var cd =  $(".qujicplist"+tname+' div').length;
          

          if(cd < 1){
          
            href= $(".qujicplist"+tname+" + a").attr('href') ;
            eval(href);
          
          }


         

          


}

function deltc(id){

            var news  = $("#picddel"+id).find('input').attr('name');


                    $("#picddel"+id).remove();

                    if(  $("#picddel"+id).length < 1){

                         $("#yingxianss").html("<input type='hidden' name='"+news+"'>");

                    }
}

if( typeof  KindEditor !=='undefined' ){

 KindEditor.ready(function(K) { 

                   var editor = K.editor({
                    allowFileManager : false,
                    filePostName : 'all',
                      
                });
});

}

</script>
