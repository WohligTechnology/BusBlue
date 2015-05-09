
<div class="row"  >
    <div class="col-lg-5 col-sm-5">
        <section class="panel1">
            
					<div class="form-group">
						<div class="col-sm-6">
						  <input type="text" id="normal-field" class="form-control number" name="number" value="<?php echo set_value('number');?>" ><br>
						  </div>
						  <div class="col-sm-6">
						  <a class="btn btn-info myformsubmit">Enter</a>
						</div>
					</div>	
				
       
        </section>
    </div>
</div>
   <div class="row"  >
    <div class="col-lg-5 col-sm-5">
        <section class="panel1">
            
					<div class="form-group" id=>
						<div class="col-sm-6">
						</div>
					</div>	
				
       
        </section>
    </div>
</div>
<!--
<div class="row  col-lg-3 col-sm-3" >
    <div class="col-md-12">
        <section class="panel2">
            <div id="formcategory" class="form-group">
						  <input type="text" id="normal-field" class="form-control number" name="number" value="<?php echo set_value('number');?>" ><br>
					<a class="btn btn-info myformsubmit">Enter</a>
              </div>
        </section>
    </div>
 </div>
-->
 <br>
 <div class="">
    <div class="row  col-lg-3 col-sm-3" >
        <div class="col-md-12">
            <section class="panel2">
                <div id="formcategory" class="form-group">
                             <?php
						
						echo form_dropdown('category',$category,set_value('category'),'id="select2" class="chzn-select form-control" 	data-placeholder="Choose a Category..."');
					?><br>
                        <a class="btn btn-info myformsubmit">Enter</a>
                  </div>
            </section>
        </div>
     </div>
    <div class="row  col-lg-3 col-sm-3" >
        <div class="col-md-12">
            <section class="panel2">
                <div id="formcategory" class="form-group">
                               <?php
						
						echo form_dropdown('listing',$listing,set_value('listing'),'id="select1" class="chzn-select form-control" 	data-placeholder="Choose a Listing..."');
					?>
                       <br>
                        <a class="btn btn-info myformsubmit">Enter</a>
                  </div>
            </section>
        </div>
     </div>
<!--
    <div class="row  col-lg-3 col-sm-3" >
        <div class="col-md-12">
            <section class="panel2">
                <div id="formcategory" class="form-group">
                               
                       <br>
                        <a class="btn btn-info myformsubmit">Enter</a>
                  </div>
            </section>
        </div>
     </div>
-->
</div>
<script>
    $(".myformsubmit").click(function () {
        $.getJSON(
            "<?php echo base_url(); ?>index.php/site/submitnumber", {
                number: $(".number").val()
            },
            function (data) {
                console.log(data);
                nodata = data;
                // $("#store").html(data);
                allenquiries(data);

            }
        );
//        return false;
    });
    
    
    function allenquiries(data) {
        $("#enquiries .allenquiries").html("");
        for(var i=0;i<data['allenquiries'].length;i++)
        {
            console.log(data['allenquiries'][i].id);
            var id=data['allenquiries'][i].id;
            var listingname=data['allenquiries'][i].listingname;
            var categoryname=data['allenquiries'][i].categoryname;
            var comment=data['allenquiries'][i].comment;
//            $("#enquiries .allenquiries").append(data['allenquiries'][i].id);
             $("#enquiries .allenquiries").append("<div class='well'><div>Listing:"+listingname+"</div><div>Category:"+categoryname+"</div><div>Comment:"+comment+"</div></div>");
//             $("#enquiries .allenquiries").append("<div class='well'><div>Listing:"+data['allenquiries'][i].listingname+"</div><div>Category:"+data['allenquiries'][i].categoryname+"</div><div>Comment:"+data['allenquiries'][i].comment+"</div></div>");
        }

    };
</script>
