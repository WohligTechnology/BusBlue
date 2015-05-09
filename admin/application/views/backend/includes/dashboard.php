<div class="row"  >
    <div class="col-lg-5 col-sm-5">
        <section>
            
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
<br>
 <div class="row">
<!--
       <div class="row">
             
       </div>
-->
       <div class="alert alert-success"  style="display:none;" id="messageadded">
           Enquiry Added Successfully
       </div>
       <div class="alert alert-success"  style="display:none;" id="messageaddedforusercreation">
           User Updated Successfully
       </div>
        <div class="col-md-6 formcategory" style="display:none;">
          
          <div class="row panel">
               <div class="col-md-6" style="margin-top:10px;">
                    <section class="panel2">
                        <div id="formcategory" class="form-group">
                                    <input type="hidden" name="categoryid" id="categoryid" class="categoryclass">
                                     <?php

                                echo form_dropdown('category',$category,set_value('category'),'id="select1" class="chzn-select form-control categoryvalue" 	data-placeholder="Choose a Category..."');
                            ?><br>
                                <a class="btn btn-info categoryformsubmit">Enter</a>
                          </div>
                    </section>
                </div>
                <div class="col-md-6 formlisting" style="display:none;margin-top:10px;">
                    <section class="panel3">
                        <div id="formcategory" class="form-group">
                                       <?php

                                echo form_dropdown('listing',$listing,set_value('listing'),'id="select2" class="chzn-select form-control listingvalue" 	data-placeholder="Choose a Listing..."');
                            ?>
                               <br>
                                <a class="btn btn-info listingformsubmit">Enter</a>
                          </div>
                    </section>
                </div>
          </div>
          <br>
          <br>
          <div class="row panel">
                <div class="col-lg-12 col-sm-12">
                    <section class="panel2">
                        <div id="enquiries" class="form-group" style="margin-top:10px;">
                            <div class="col-sm-12 allenquiries">

                            </div>
                          </div>
                    </section>
                </div>
            </div>
     </div>
     <div  class="col-md-6">
        <div class="col-lg-6 col-sm-6">
            <section class="panel2">
                <div id="user" class="form-group">
                  <div class="userdetails">
                    
                  </div>
                </div>
                <div class="submitbuttonforuserdetails" style="display:none;">
                    <a class='btn btn-info userdetailsformsubmit'style='margin-left:64px;' id='userdetailsformsubmitid'>Submit</a>
                </div>
            </section>
        </div>
     </div>
</div>
<br>
<div>
<!--
<div class="row">
    <div class="col-lg-8 col-sm-8">
        <section class="panel2">
            <div id="enquiries" class="form-group">
				<div class="col-sm-8 allenquiries">
                    
                </div>
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
                userdetails(data);

            }
        );
//        return false;
    });
    
    $(".categoryformsubmit").click(function () {
        console.log( $(".userdetailid").val());
        console.log( $("#select1").val());
        $.getJSON(
            "<?php echo base_url(); ?>index.php/site/submitcategoryenquiry", {
                categoryvalue: $("#select1").val(),
                userid: $(".userdetailid").val()
            },
            function (data) {
                console.log(data);
                console.log("incategoryformsubmit");
                nodata = data;
                $("#messageadded").show();
                $("#messageaddedforusercreation").hide();
                // $("#store").html(data);
//                alert(data);
//                allenquiries(data);
//                userdetails(data);
                

            }
        );
        return false;
    });
    
    $(".listingformsubmit").click(function () {
        console.log( $(".userdetailid").val());
        console.log( $("#select2").val());
        $.getJSON(
            "<?php echo base_url(); ?>index.php/site/submitlistingenquiry", {
                listingvalue: $("#select2").val(),
                userid: $(".userdetailid").val()
            },
            function (data) {
                console.log(data);
                console.log("inlistingformsubmit");
                nodata = data;
                $("#messageadded").show();
                $("#messageaddedforusercreation").hide();
                // $("#store").html(data);
//                alert(data);
//                allenquiries(data);
//                userdetails(data);
                

            }
        );
        return false;
    });
    
    $("#userdetailsformsubmitid").click(function () {
        console.log( $(".userdetailid").val());
//        alert("hello");
//        console.log( $(".listingvalue").val());
        $.getJSON(
            "<?php echo base_url(); ?>index.php/site/submituserdetails", {
//                listingvalue: $(".listingvalue").val(),
                userid: $(".userdetailid").val(),
                username: $(".userdetailname").val(),
//                useraddress: $(".userdetailaddress").val(),
//                usercity: $(".userdetailcity").val(),
                userphone: $(".userdetailphone").val(),
//                userdob: $(".userdetaildob").val(),
                useremail: $(".userdetailemail").val(),
//                userpincode: $(".userdetailpincode").val()
                
            },
            function (data) {
                console.log(data);
                console.log("inuserdetailsformsubmit");
                nodata = data;
                $("#messageadded").hide();
                $("#messageaddedforusercreation").show();
                // $("#store").html(data);
//                alert(data);
//                allenquiries(data);
//                userdetails(data);
                

            }
        );
        return false;
    });
    
    
    function allenquiries(data) {
        $(".formcategory").show();
        $(".formlisting").show();
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
        }
//        for (var key in userdetail) {
//  console.log(key);
//}
//        console.log(data(userdetail.id));

    };
    function userdetails(data) {
        $(".submitbuttonforuserdetails").show();
        $("#user .userdetails").html("");
            console.log(data['userdetail'].id);
            var id=data['userdetail'].id;
//            var address=data['userdetail'].address;
            var name=data['userdetail'].name;
            var phone=data['userdetail'].phone;
            var email=data['userdetail'].email;
            document.getElementById("categoryid").value = id;
             $("#user .userdetails").append("<table><tr><td>Name:</td><td><input type='text' name='name' value='"+name+"' class='form-control userdetailname'><input type='hidden' name='id' value='"+id+"' class='form-control userdetailid'></td></tr><tr><td>Email:</td><td><input type='email' name='email' value='"+email+"' class='form-control userdetailemail'></td></tr><tr><td>Phone:</td><td><input type='text' name='phone' value='"+phone+"' class='form-control userdetailphone'></td></tr></table>");
//        <tr><td><a class='btn btn-info userdetailsformsubmit' id='userdetailsformsubmitid'>Submit</a></td><td></td></tr>
        
//             $("#user .userdetails").append("<div>Name:"+firstname+"</div><div>Address:"+address+"</div><div>City:"+city+"</div><div>Contact:"+contact+"</div><div>DOB:"+dob+"</div><div>Email:"+email+"</div><div>Pincode:"+pincode+"</div>");

    };
</script>
