<div class="container-fluid" style="margin:10px 10px;">
    <div class="container">
        <div class="col-md-12">
            <div class="signup-header" style="margin-bottom: 10px;" >
                Pick your stuff. </br>
            </div>
            <div class="home-text3">
                Tell us the kinds of things you are looking </br> for and we will help you find them.
            </div>
        </div>
    </div>
    <?php
   /*  foreach($classes as $class ){
        http://www.fetchdelivers.com/images/
        echo $class['class_name'];
    }  */?>
    <div class="container" style="margin-top: 20px;">
        <div class="col-md-2">

        </div>

        <div class="col-md-8" style="padding:5px;">
            <?php
             foreach($classes as $class ){ ?>
                <div class="focus pic" id="<?php echo $class['class_id'] ;?>" style="width:180px;height:120px;display:block;float:left;margin:20px;padding: 8px;">
                    <a href="javascript:void(0);" onclick="getClassList('<?php echo $class['class_id'];?>');"><img class="img-center " style="" src="http://www.fetchdelivers.com/images/<?php echo $class['images']; ?>" width="80px" height="100px;" alt="products for fetchdelivers"/></a><br>
                    <div class="text-center" style=""><?php echo $class['class_name']; ?></div>
                </div>
           <?php
             } ?>
        </div>

        <!--div class="col-md-2">
            <img class="img-responsive img-center" src="<?php echo base_url();?>/img/stuffs/7910510698.jpg" width="30%" alt="products for fetchdelivers"/>
            TREAT
        </div>
        <div class="col-md-2">
            <img class="img-responsive img-center" src="<?php echo base_url();?>/img/pets/newanimal_1.jpg"  width="50%"alt="products for fetchdelivers">
        </div-->
        <div class="col-md-2">

        </div>
    </div>
    <div class="container" style="margin:20px;">
        <div class="col-md-12">
            <button type="submit" id="submit" class="btn-add" onclick="sendClassId();">&nbsp;&nbsp; NEXT &nbsp;&nbsp;</button>
        </div>
    </div>
    <!--div class="container" style="margin-top: 20px;">
        <div class="col-md-3">

        </div>
        <div class="col-md-2">
            <img class="img-responsive img-center" src="<?php echo base_url();?>/img/pets/newanimal_4.jpg" width="50%" alt="products for fetchdelivers">
        </div>
        <div class="col-md-2">
            <img class="img-responsive img-center" src="<?php echo base_url();?>/img/pets/newanimal_5.jpg" width="50%" alt="products for fetchdelivers">
        </div>
        <div class="col-md-2">
            <img class="img-responsive img-center" src="<?php echo base_url();?>/img/pets/newanimal_6.jpg" width="50%" alt="products for fetchdelivers">
        </div>

        <div class="col-md-3">

        </div>
    </div>
    <div class="container" style="margin-top: 20px;margin-bottom: 20px;">
        <div class="col-md-3">

        </div>
        <div class="col-md-2">
            <img class="img-circle img-center" src="<?php echo base_url();?>/img/pets/newanimal_7.jpg" width="50%" alt="products for fetchdelivers">
        </div>
        <div class="col-md-2">
            <img class=" img-circle img-responsive img-center" src="<?php echo base_url();?>/img/pets/newanimal_8.jpg" width="50%" alt="products for fetchdelivers">
        </div>
        <div class="col-md-2">
            <img class="img-circle img-responsive img-center" src="<?php echo base_url();?>/img/pets/newanimal_9.jpg" width="50%" alt="products for fetchdelivers">
        </div>

        <div class="col-md-3">

        </div>
    </div-->
</div>

