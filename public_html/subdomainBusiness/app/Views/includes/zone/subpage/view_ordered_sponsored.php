<!-- <li id='"+id+"' class='draggable_div' style='position:relative;'><p>"+data[i].name+"</p> <button class='counter' title='sponsor Order' style='top: 0px; position:absolute; right: 0px;  padding: 3px 7px; border-radius: 15px;'>"+j+"</button></li> -->

<style type="text/css">

.draggable_div{

	width:150px !important;

	height:100px !important;

	background: #5f6e87;

	margin-left: 20px !important;

	text-align: center;

	float: left;

	color: white;

	cursor: pointer;

	margin-top: 12px !important;

	

}

</style>

<?php

if($data){

	$i=1;

	echo "<ul id='sortable'>";

	/*var_dump($data);

	exit();*/

	foreach ($data as $ordered_business) { ?>

	<li class='draggable_div' style='position:relative;' id="<?php echo $ordered_business['business_id'];  ?>"><p><?php echo $ordered_business['name'] ?></p> <button class='counter' title='sponsor Order' style='top: 0px; position:absolute; right: 0px;  padding: 3px 7px; border-radius: 15px;'><?php echo $i; ?></button></li>

	

<?php

	

	$i++;

}

	echo "</ul>";

} else{ ?>

 <div class="container_tab_header" id="not_found" style="background-color:#222; color:#CCC; font-size:13px; text-align:center; margin-top:10px; margin-bottom:0px;">No Sponsor Business Found</div>

	

<?php 

}



?>

<script type="text/javascript">

$(document).ready(function(){

$('#sortable').sortable({



	update: function(event, ui){

		var data_array=[];

		var i=0;

		var order="";

		$(".draggable_div").each(function(i){

			var id=$(this).attr('id');

			order+=id+",";

			$('#'+$(this).attr('id')).find('.counter').text(i+1);



		});

		var data={order:order};

		$.post("<?=base_url('Zonedashboard/sponser_business_reorder')?>/",data,function(){

			console.log(data);

				

	    });	

		

	}

});

});

</script>