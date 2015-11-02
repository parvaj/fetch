<div class="container-fluid" style="margin:10px 10px;">
    <div class="container">
        <div class="col-md-12">
            <div class="signup-header" style="margin-bottom: 10px;" >
                Pick your pet </br>
            </div>
            <div class="home-text3">
                Click on the pet you are shopping for and <br> we will help your find your food and other <br> goodless!
            </div>
            <?php
            foreach($departmentlist as $department){

                // echo $department['department_name'];
            }

            ?>
        </div>
    </div>
    <div class="container" style="margin-top: 20px;">
        <div class="col-md-3">

        </div>
        <div class="col-md-6">
<?php
        foreach($departmentlist as $department){ ?>

            <a class="" href=""><img class="img-responsive img-center" src="<?php echo base_url();?>/img/pets/<?php echo $department['petimg'];?>" width="50%" alt="products for fetchdelivers">

        <?php } ?>
        </div>
        <!--div class="col-md-2">
            <img class="img-responsive img-center" src="<?php echo base_url();?>/img/pets/newanimal_2.jpg" width="50%" alt="products for fetchdelivers">
        </div>
        <div class="col-md-2">
            <img class="img-responsive img-center" src="<?php echo base_url();?>/img/pets/newanimal_1.jpg"  width="50%"alt="products for fetchdelivers">
        </div-->
        <div class="col-md-3">

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
    <!--div class="container" style="margin-top: 20px;margin-bottom: 20px;">
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

