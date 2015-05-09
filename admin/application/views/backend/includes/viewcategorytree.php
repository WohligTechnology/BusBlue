<div class=" row" style="padding:1% 0;">
    <div class="col-md-12">
        <div class=" pull-right col-md-1 createbtn"><a class="btn btn-primary" href="<?php echo site_url('site/createcategory'); ?>"><i class="icon-plus"></i>Create </a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Category Details
            </header>
            <ul>
                <?php foreach($table as $row){?>
                <div style="margin-left:20px;margin-top:10px;">
                <li class="addsubcategoryclass">
                    <a href="#" class="func" style="padding-right: 15px;vertical-align:bottom;"><input type="hidden" class="addsubcategory" value="<?php echo $row->id;?>">
                        <?php echo $row->name;?>
                       </a>
                       
                       <a class="btn  btn-primary btn-xs" style="margin-right:6px,margin-top:3px;" href="<?php echo site_url('site/editcategory?id=').$row->id;?>"><i class="icon-pencil"></i></a>
                       <a  class="btn btn-danger btn-xs"  style="margin-right:6px,margin-top:3px;"href="<?php echo site_url('site/deletecategory?id=').$row->id;?>"><i class="icon-trash "></i></a>
                       
                    <div class="showsubcategory" style="display:none;"></div>
                </li>
                </div>
                <br>
                <?php }?>
            </ul>
        </section>
    </div>
</div>

<script>
    $(document).ready(function () {

        $(".addsubcategoryclass a.func").click(function () {
            var value1 = $(this).children(".addsubcategory").val();
            var abc = $(this);
             console.log(value1)
             
                
            $.getJSON(
                "<?php echo base_url(); ?>index.php/site/getsubcategorybyparent", {
                    //                number: $(".number").val()
                    categoryid: value1
                },
                function (data) {
                    console.log(data);
                    nodata = data;
                    // $("#store").html(data);
                    subcategories(abc, data);

                }
            );
            $(this).parent(".addsubcategoryclass").children(".showsubcategory").toggle();
            return false;
        });
        
    });

    function subcategories(element, data) {
        //        $(".formcategory").show();
        //        $(".formlisting").show();
        //console.log(element);
        $(element).parent(".addsubcategoryclass").children(".showsubcategory").html("");
        for (var i = 0; i < data.length; i++) {
            console.log(data[i].id);
            var id = data[i].id;
            var name = data[i].name;
            //            $("#enquiries .allenquiries").append(data['allenquiries'][i].id);
            $(element).parent(".addsubcategoryclass").children(".showsubcategory").append("<li class='addsubcategoryclass' style='margin-left:30px;margin-top:5px;'><a href='#' class='func' style='padding-right: 15px;'><input type='hidden' class='addsubcategory' value='" + id + "'>" + name + "</a><a class=' btn  btn-primary btn-xs' style='margin-right:6px,margin-top:13px;' href='<?php echo site_url('site/editcategory?id=');?>"+id+"'><i class='icon-pencil'></i></a><a  class='btn btn-danger btn-xs' style='margin-right:6px,margin-top:13px;' href='<?php echo site_url('site/deletecategory?id=');?>"+id+"'><i class='icon-trash '></i></a><div class='showsubcategory' style='display:none;'></div></li>");




        }
        
            console.log($(element).parent(".addsubcategoryclass").children(".showsubcategory").children(".addsubcategoryclass").children("a.func").html());
            $(element).parent(".addsubcategoryclass").children(".showsubcategory").children(".addsubcategoryclass").children("a.func").click(function () {
                var value1 = $(this).children(".addsubcategory").val();
                console.log(value1);
                var abc = $(this);
                $.getJSON(
                    "<?php echo base_url(); ?>index.php/site/getsubcategorybyparent", {
                        //                number: $(".number").val()
                        categoryid: value1
                    },
                    function (data) {
                        console.log(data);
                        nodata = data;
                        // $("#store").html(data);
                        subcategories(abc, data);

                    }
                );
                $(this).parent(".addsubcategoryclass").children(".showsubcategory").toggle();
                return false;
                
            });
        
        
        //        for (var key in userdetail) {
        //  console.log(key);
        //}
        //        console.log(data(userdetail.id));






    };
</script>
