            <div class="container-fluid" style="margin: 15px 0 0;">
                <div class="container">
                    <div class="col-md-6">
                        <form method="post" action="<?php echo base_url();?>product/searchproduct/" id="">
                        <div class="scrolling-font"> <?php echo $departmentName; ?> Stuff </div>
                        <div class="home-text3"> select a category or simply browse this <br> page to find the items you are looking for!</div>
                        <div class="row" style="margin: 10px 0 10px;">
                            <div class="col-md-4 text-center">
                                <select name="brand" id="brand">
                                <?php

                                     foreach($brands as $brand ){ ?>
                                            <option value="<?php echo $brand['manufacturer_id'];?>" <?php echo ($urlSegment['brandSection'] == $brand['manufacturer_id'])?"selected":"" ;?>><?php echo $brand['manufacturer_name'];?> </option>
                                     <?php   } ?>
                                 </select>
                            </div>
                            <div class="col-md-4">
                                <select name="category" id="category">

                                        <?php
                                        foreach($classes as $class ){ ?>

                                        <option value="<?php echo $class['class_id'];?>" <?php echo ($urlSegment['classSection'] == $class['class_id'])?"selected":"" ;?>><?php echo $class['class_name'];?></option>

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
                        <button type="button" class="btn-add" onclick="loadProducts();"> SUBMIT </button>
                        <!--img class="img-responsive" src="<?php //echo base_url();?>img/singup_now.jpg" alt="Signup button for fetchdelivers.com" width="130" height="28px"-->
                    </div>
                    </form>
                    <div class="col-md-6">
                        <img class="img-responsive" src="<?php echo base_url();?>img/dog_stuff.jpg" alt="Signup button for fetchdelivers.com">
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


            <div class="container-fluid" >

            <?php

                $groupId="";
                foreach($products as $product ){
                   // echo "group Id".$groupId."  pg id:".$product['group_id']."<br />";
                    if($groupId != $product['group_id']) {
                        if($groupId!=""){
            ?>

                <div class="row" style="margin-top:5px;">
                    <div class="col-md-3 text-left">
                        Save 2.5% with <br> recurring order
                    </div>
                    <div class="col-md-3 text-center">
                        Recurring Order
                    </div>
                    <div class="col-md-3 text-left">
                        <select name="frequency_<?php echo $groupId?>" id="frequency_<?php echo $groupId?>">
                            <?php
                            foreach($frequency as $frequencies){
                                ?>
                                <option value="<?php echo $frequencies['frequency_id'];?>" <?php echo  ($frequencies['list_order']==2)?"selected":"" ;?> > <?php echo $frequencies['frequency'];?> </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-3 text-right">
                        Quantity  <input type="text" class="p-qty" name="productQty" id="number_qty" value="1">
                    </div>
                    <script language="javascript" type="text/javascript">
                       // commonCombo(<?php echo $groupId; ?>);
                       function addPrice(pid){
                           var price = jQuery( "span#pprice"+pid ).html();
                           jQuery('#currentPrice'+<?php echo $groupId ;?>).text('$'+price);
                           jQuery('input#number_qty'+pid).val("1");

                       }
                       addPrice(<?php echo $groupId ;?>);
                    </script>
                </div>

            </div></div></div>
                            <div class="col-md-2"></div>
                            </div>

            <?php
                        }


            ?>
                        <div class="container" >
                        <div class="col-md-1">

                        </div>
                        <div class="col-md-10" style="margin-top: 5px; padding-top:5px;">
                        <div class="row" style="border: 1px #c0c0c0 solid;margin-top: 5px; padding-top:5px;">
                        <div class="col-md-2">
                            <a href="<?php echo base_url() . "product/item/" . $product['group_id']; ?>">
                                <img class="img-responsive img-center"
                                     src="http://www.fetchdelivers.com/images/<?php echo $product['img']?>"
                                     alt="products for fetchdelivers">
                            </a>

                            <div class="p-ratings">
                                <img src="<?php echo base_url();?>img/rating0.png"
                                     alt="products ratings for fetchdelivers">
                            </div>
                            <div class=""> PRODUCT RATING</div>
                        </div>
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-6 text-left" >
                                    <div class="font-bold"> <?php echo $product['manufacturer_name']; ?> </div>
                                    <div class="font-bold">   <?php echo $product['product_name']; ?> </div>
                                    <div class="font-bold delivery-date"> <span style="color:#fbb03b;">Next available delivery: <?php echo $product['nextDeliveryDate'];?> </span><span style="color:#FE5B00;"><?php //echo $nextDelivery; ?></span></div>
                                </div>
                                <div class="col-md-6 text-right" >
                                    <div class="our-price">OUR PRICE <span
                                        <span id="currentPrice_<?php echo $product['group_id']; ?>" style="color:#FE5B00;"> <?php echo $product['price']; ?> </span>
                                    </div>
                                    <button type="submit" name="BUY"
                                            id="btnbuy_<?php echo $product['group_id']; ?>"
                                            value="ADD TO CART" class="btn-add">ADD TO CART
                                    </button>
                                </div>
                            </div>
                            <div class="row font-bold" style="border-bottom: 2px solid #fbb03b;">
                                <div class="col-md-4 text-left">
                                    Options
                                </div>
                                <div class="col-md-4 text-center">
                                    Per Lbs
                                </div>
                                <div class="col-md-4 text-right">
                                    Price
                                </div>
                            </div>
            <?php
                            $groupId = $product['group_id'];
                        }

            ?>
                        <div class="row"  style="border-bottom: 1px solid gainsboro;margin-top:5px;">
                            <div class="col-md-4 text-left">
                                <input type="radio" name="productid" id="productid_<?php echo $product['product_id'];?>" value="<?php echo $product['product_id'];?>" <?php  echo ($groupId == $product['product_id']?"checked":"");?> onclick="addPrice(<?php echo $product['product_id'] ;?>)" />
                                <?php echo  $product['weight'] ." ".$product['unit'] ;?>
                            </div>
                            <div class="col-md-4 text-center">
                                $<?php echo number_format($product['price'], 2); ?>
                            </div>
                            <div class="col-md-4 text-right">
                                $ <span id="pprice<?php echo $product['product_id'] ;?>"><?php echo number_format($product['price'],2);?></span>
                            </div>
                        </div>


            <?php
                }
            ?>
                            <div class="row" style="margin-top:5px;">
                                <div class="col-md-3 text-left">
                                    Save 2.5% with <br> recurring order
                                </div>
                                <div class="col-md-3 text-center">
                                    Recurring Order
                                </div>
                                <div class="col-md-3 text-left">
                                    <select name="frequency_<?php echo $groupId?>" id="frequency_<?php echo $groupId?>">
                                        <?php
                                        foreach($frequency as $frequencies){
                                            ?>
                                            <option value="<?php echo $frequencies['frequency_id'];?>" <?php echo  ($frequencies['list_order']==2)?"selected":"" ;?> > <?php echo $frequencies['frequency'];?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-3 text-right">
                                    Quantity  <input type="text" class="p-qty" name="productQty" id="number_qty_<?php echo $groupId; ?>" value="1">
                                </div>
                                <script language="javascript" type="text/javascript">
                                    $(function(){ alert('heloooo');
                                        $("#frequency_<?php echo $groupId;?>").sexyCombo({
                                            skin: "frequency",
                                            triggerSelected: true
                                        });
                                    });
                                    function addPrice(pid){
                                        var price = jQuery( "span#pprice"+pid ).html();
                                        jQuery('#currentPrice'+<?php echo $groupId ;?>).text('$'+price);
                                        jQuery('input#number_qty'+pid).val("1");

                                    }
                                    addPrice(<?php echo $groupId ;?>);
                                </script>
                            </div>
                    </div>

                </div>

            </div>
                <div class="col-md-1">

                </div>
            </div>
            </div>


