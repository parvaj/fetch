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
    <div class="container" style="min-height:36px;margin:20px;">
        <div class="col-md-12" id="addbutton">
        </div>
    </div>
    <div class="container" style="margin-top: 20px;">
        <div class="col-md-2">
        </div>
        <div class="col-md-8 title_text" style="padding:5px;">
            <?php
             foreach($classes as $class ){ ?>
                <div class="pic-round" id="<?php echo $class['class_id'] ;?>" style="">
                    <a class="focus" href="javascript:void(0);" onclick="getClassList('<?php echo $class['class_id'];?>','<?php echo $class['class_name']; ?>');"><img class="img-center " style="" src="http://www.fetchdelivers.com/images/<?php echo $class['images']; ?>" width="80px" height="100px;" alt="products for fetchdelivers"/></a><br>
                    <div class="text-center" style=""><?php echo $class['class_name']; ?></div>
                </div>
           <?php
             } ?>
        </div>
        <div class="col-md-2">
        </div>
    </div>
    <div class="container" style="margin:20px;">
        <div class="col-md-12">
            <button type="submit" id="submit" class="btn-add" onclick="sendClassId(<?php echo $urlSegment['deptSection'];?>);">&nbsp;&nbsp; NEXT &nbsp;&nbsp;</button>
        </div>
    </div>
</div>

