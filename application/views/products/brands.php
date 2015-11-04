<div class="container-fluid" style="margin:10px 10px;">
    <div class="container">
        <div class="col-md-12">
            <div class="signup-header" style="margin-bottom: 10px;" >
                Know your brands? </br>
            </div>
            <div class="home-text3">
                Pick your favorite brands - select as many <br> as you'd like and you are ready to shop!
            </div>
        </div>
    </div>
    <div class="container" style="min-height:36px;margin:20px;">
        <div class="col-md-12" id="addbutton">
        </div>
    </div>

    <div class="container title_text" style="margin-top: 20px;">
        <div class="col-md-2">

        </div>
        <div class="col-md-8">
            <?php
            foreach($brands as $brand ) { ?>

                <div class="brand-round" id="<?php echo $brand['manufacturer_id'] ;?>" style="">
                    <a class="focus" href="javascript:void(0);" onclick="getClassList('<?php echo $brand['manufacturer_id'];?>','<?php echo $brand['manufacturer_name'];?>');"><img class="img-center " style="" src="http://www.fetchdelivers.com/images/brands/<?php echo $brand['graphic']; ?>" width="75px" height="" alt="<?php echo $brand['manufacturer_name']; ?>"/></a><br>
                    <div class="text-center" style=""><?php echo $brand['manufacturer_name']; ?></div>
                </div>

         <?php   } ?>


        </div>
        <div class="col-md-2">

        </div>
    </div>
    <div class="container" style="margin:20px;">
        <div class="col-md-12">
            <button type="submit" id="submit" class="btn-add" onclick="sendBrandId(<?php echo $_SESSION['department_id'];?>);">&nbsp;&nbsp; NEXT &nbsp;&nbsp;</button>
        </div>
    </div>
</div>