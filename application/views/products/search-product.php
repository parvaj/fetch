<?php //echo $urlSegment['deptSection']; die;?>
<div class="container" xmlns="http://www.w3.org/1999/html">
                <div class="row">
                    <div class="col-md-4">
                        <div>
                        <h6 >Classes</h6>

                        <div>
                        <?php
                            foreach($classes as $class )
                                //echo "<a href='".base_url()."product/products/".$urlSegment['deptSection']."/".$class['class_id']."'>".$class['class_name']."</a>, ";
                        ?>
                        </div>
                    </div>
                    <?php
                    if(!empty($brands))
                    {
                    ?>
                        <div >
                            <h6 >BRAND</h6>

                            <div>
                                <?php
                                foreach($brands as $brand )
                                    //echo "<a href='".base_url()."product/products/".$urlSegment['deptSection']."".($urlSegment['classSection']!=null?"/".$urlSegment['classSection']:"")."/".$brand['manufacturer_id']."'>".$brand['manufacturer_name']."</a>, ";
                                ?>
                            </div>
                        </div>

                    <?php
                    }
                        if(!empty($subClasses))
                        {
                    ?>
                            <div >
                                <h6 >Sub-Classes</h6>

                                <div>
                                    <?php
                                    foreach($subClasses as $subClass )
                                       echo "<a href='".base_url()."product/products/".$urlSegment['deptSection']."".($urlSegment['classSection']!=null?"/".$urlSegment['classSection']:"")."".($urlSegment['brandSection']!=null?"/".$urlSegment['brandSection']:"/2")."/".$subClass['subclass_id']."'>".$subClass['subclass_name']."</a>, ";
                                    ?>
                                </div>
                            </div>
                    <?php
                        }
                    ?>
                    </div>
                    <?php
                        if(!empty($products))
                        {
                    ?>
                        <div class="col-md-8">
                           <h1> Product List</h1>
                            <div >
                            <?php
                                foreach($products as $product ){
                            ?>
                                    <div style="float: left;width: 150px; height:250px; border: 1px solid #a0a0a0;padding: 5px; margin: 5px;">
                                        <form method="post" action="<?php echo base_url();?>checkout/additems/" id="frm__<?php echo $product['group_id'];?>">
                                        <div><?php echo $product['manufacturer_name'] ;?></div>
                                        <img src="" style="width: 50px; height: 70px; border: 1px solid #008080">
                                        <div><?php echo "<a href='".base_url()."product/item/".$product['group_id']."'>".$product['product_name']."</a> "; ?></div>
                                        <div>Price: $<?php echo number_format($product['price'],2);?>
                                            <input type="hidden" name="productid" id="productid_<?php echo $product['group_id'];?>" value="<?php echo $product['group_id'];?>">
                                            <input type="hidden" name="productPrice" id="productPrice_<?php echo $product['group_id'];?>" value="<?php echo $product['price'];?>">
                                            <input type="hidden" name="productQty" id="productQty_<?php echo $product['group_id'];?>" value="1">
                                            <input type="hidden" name="productFrequency" id="productFrequency_<?php echo $product['group_id'];?>" value="1">
                                            <input type="hidden" name="manufacturerId" id="manufacturerId_<?php echo $product['group_id'];?>" value="<?php echo $product['manufacturer_id'];?>">

                                        </div>
                                        <div><input type="submit" name="btnbuy" id="btnbuy_<?php echo $product['group_id'];?>" value="Add To Cart"></div>
                                        </form>
                                    </div>
                            <?php
                                }

                            ?>
                            </div>
                        </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
            <?php
                if( $urlSegment['deptSection']==3 )
                    $deptName = 'Dog';
                else if($urlSegment['deptSection']==2)
                    $deptName = 'Cat';
                else if($urlSegment['deptSection']==1)
                    $deptName = 'Bird';
            ?>
            <div class="container-fluid" style="margin: 15px 0 0;">
                <div class="container">
                    <div class="col-md-6">
                        <form method="post" action="<?php echo base_url();?>product/products/" id="">
                        <div class="scrolling-font"> <?php echo $deptName; ?> Stuff </div>
                        <div class="home-text3"> select a category or simply browse this <br> page to find the items you are looking for!</div>
                        <div class="row" style="margin: 10px 0 10px;">
                            <div class="col-md-4 text-center">
                                <select name="brand" id="brand">

                                <?php

                                     foreach($brands as $brand ){ ?>
                                            <option value="<?php echo $brand['manufacturer_id'];?>"><?php echo $brand['manufacturer_name'];?> </option>
                                     <?php   } ?>
                                 </select>
                            </div>
                            <div class="col-md-4">
                                <select name="category" id="category">

                                        <?php
                                        foreach($classes as $class ){ ?>

                                        <option value="<?php echo $class['class_id'];?>"><?php echo $class['class_name'];?></option>

                                    <?php } ?>

                                </select>
                            </div>
                            <div class="col-md-4">
                                <select name="petType" id="petType">

                                    <?php   foreach($subClasses as $subClass ) {?>
                                        <option value="<?php echo $subClass['subclass_id'];?>"> <?php echo $subClass['subclass_name'];?> </option>
                                  <?php }  ?>

                                </select>
                            </div>
                        </div>
                            <input type="hidden" name="deptId" id="deptId" value="<?php echo $urlSegment['deptSection'];?>">
                        <!--button type="button" class="btn-add" onclick="\"javascript:window.location='<?php //echo base_url();?>product/products/<?php //echo $urlSegment['deptSection'];?>/22/62'\"> SUBMIT </button-->
                        <button type="submit" class="btn-add"> SUBMIT </button>
                        <!--img class="img-responsive" src="<?php //echo base_url();?>img/singup_now.jpg" alt="Signup button for fetchdelivers.com" width="130" height="28px"-->
                    </div>
                    </form>
                    <div class="col-md-6 img-responsive">
                        <img class="" src="<?php echo base_url();?>img/dog_stuff.jpg" alt="Signup button for fetchdelivers.com">
                    </div>
                </div>
            </div>
            <div class="container-fluid" style="margin:10px 10px;">
                <div class="container">
                    <div class="col-md-4" style="border:3px solid #B6C6EB;"> </div>
                    <div class="col-md-4">
                        <div class="take-your-pick">
                            Take your pick
                        </div>
                    </div>
                    <div class="col-md-4" style="border:3px solid #B6C6EB;">

                    </div>

                </div>
            </div>
            <div class="container-fluid" style="margin:10px 10px;">
                <div class="container">
                    <?php
                        foreach($products as $product ){
                    ?>
                        <div class="col-md-3">
                            <form method="post" action="<?php echo base_url();?>checkout/additems/" id="frm__<?php echo $product['group_id'];?>">
                                <div class="brand-stuff"> <?php echo $product['manufacturer_name'] ;?> </div>
                                <div class="product-head"> <?php echo $product['product_name'];?> </div>
                                <img class="fetchimg" src="<?php echo base_url();?>img/products1.jpg" alt="products for fetchdelivers">
                                <div class=""> product rating </div>
                                <div class="our-price">OUR PRICE <span style="color:#FE5B00;">$<?php echo number_format($product['price'],2);?> </span></div>
                                <div class="p-ratings" >
                                    <img  src="<?php echo base_url();?>img/rating0.png" alt="products ratings for fetchdelivers">
                                </div>
                                    <input type="hidden" name="productid" id="productid_<?php echo $product['group_id'];?>" value="<?php echo $product['group_id'];?>">
                                    <input type="hidden" name="productPrice" id="productPrice_<?php echo $product['group_id'];?>" value="<?php echo $product['price'];?>">
                                    <input type="hidden" name="productQty" id="productQty_<?php echo $product['group_id'];?>" value="1">
                                    <input type="hidden" name="productFrequency" id="productFrequency_<?php echo $product['group_id'];?>" value="1">
                                    <input type="hidden" name="manufacturerId" id="manufacturerId_<?php echo $product['group_id'];?>" value="<?php echo $product['manufacturer_id'];?>">
                                    <button type="submit" name="BUY" id="btnbuy_<?php echo $product['group_id'];?>" value="ADD TO CART" class="btn-add">ADD TO CART </button>

                            </form>
                        </div>
                   <?php } ?>

                    <!--div class="col-md-3">
                        <div class="brand-stuff"> Brand Name </div>
                        <div class="product-head"> Product Name </div>
                        <img class="fetchimg" src="<?php echo base_url();?>img/products1.jpg" alt="products for fetchdelivers">
                        <div class=""> product rating </div>
                        <div class="our-price">OUR PRICE <span>$0.00 </span></div>
                        <div class="p-ratings" >
                            <img  src="<?php echo base_url();?>img/rating0.png" alt="products ratings for fetchdelivers">
                        </div>
                        <button type="button" class="btn-add">ADD TO CART </button>
                    </div>
                    <div class="col-md-3">
                        <div class="brand-stuff"> Brand Name </div>
                        <div class="product-head"> Product Name </div>
                        <img class="fetchimg" src="<?php echo base_url();?>img/products1.jpg" alt="products for fetchdelivers">
                        <div class=""> product rating </div>
                        <div class="our-price">OUR PRICE <span>$0.00 </span></div>
                        <div class="p-ratings" >
                            <img class="" src="<?php echo base_url();?>img/rating0.png" alt="products ratings for fetchdelivers">
                        </div>
                        <button type="button" class="btn-add">ADD TO CART </button>
                    </div>
                    <div class="col-md-3">
                        <div class="brand-stuff"> Brand Name </div>
                        <div class="product-head"> Product Name </div>
                        <img class="fetchimg" src="<?php echo base_url();?>img/products1.jpg" alt="products for fetchdelivers">
                        <div class=""> product rating </div>
                        <div class="our-price">OUR PRICE <span>$0.00 </span></div>
                        <div class="p-ratings" >
                            <img  src="<?php echo base_url();?>img/rating0.png" alt="products ratings for fetchdelivers">
                        </div>
                        <button type="button" class="btn-add">ADD TO CART </button>
                    </div-->

                </div>
            </div>
<script type="javascript">
    function loadProducts() {
        var brand = $("#brand option:selected").val();
        var category = $("#category option:selected").val();
        var type = $("#petType option:selected").val();
        var bb = '<?php echo base_url(); ?>';
         alert(type);
        //window.location = "<?php //echo base_url(); ?>" + "product/products/3"+"/category/type";


    }

</script>