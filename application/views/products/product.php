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
                         foreach($brands as $brand ){
                    ?>
                            <option value="<?php echo $brand['manufacturer_id'];?>" <?php echo ($urlSegment['brandSection'] == $brand['manufacturer_id'])?"selected":"" ;?>><?php echo $brand['manufacturer_name'];?> </option>
                    <?php
                         }
                    ?>
                     </select>
                </div>
                <div class="col-md-4">
                    <select name="category" id="category">
                    <?php
                        foreach($classes as $class ){
                    ?>
                            <option value="<?php echo $class['class_id'];?>" <?php echo ($urlSegment['classSection'] == $class['class_id'])?"selected":"" ;?>><?php echo $class['class_name'];?></option>
                    <?php
                        }
                    ?>

                    </select>
                </div>
                <div class="col-md-4">
                    <select name="petType" id="petType">
                    <?php
                        foreach($subClasses as $subClass ) {
                    ?>
                            <option value="<?php echo $subClass['subclass_id'];?>"> <?php echo $subClass['subclass_name'];?> </option>
                    <?php
                        }
                    ?>

                    </select>
                </div>
            </div>
            <input type="hidden" name="deptId" id="deptId" value="<?php echo $urlSegment['deptSection'];?>">
            <button type="button" class="btn-add" onclick="loadProducts();"> SUBMIT </button>
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
    $largePrice ="";
    foreach($products as $product ){

        if($groupId != $product['group_id'] ) {
            //$largePrice = $product['price'];
            if($groupId!=""){
                //echo $largePrice." ".$largestProductId;
                if( $classId == '22' || $classId == '31'  ){
                    $largestPrice = ($largePrice*2) - ($largePrice*2)*0.025;
?>
                    <div class="row"  style="border-bottom: 1px solid gainsboro;margin:5px 5px;">

                        <div class="col-md-5 text-left">
                            <input type="radio" name="productid" id="productid_<?php echo $largestProductId;?>" value="<?php echo $largestProductId;?>" <?php // echo ($groupId == $product['product_id']?"checked":"");?> onclick="addLPrice(<?php echo $largestProductId ;?>,<?php echo $groupId ;?>);" />
                            <?php echo  $productWeight*2 ." ".$productUnit ." "."( 2 *".$productWeight."-".$productUnit.") *SAVE MORE*" ;?>
                        </div>
                        <div class="col-md-3 text-center">
                            <?php if($productUnit == 'lbs') { ?>
                                $<?php echo number_format($largestPrice/($productWeight*2), 2); ?>
                            <?php  }  ?>
                        </div>
                        <div class="col-md-4 text-right">
                            $ <span id="pLprice<?php echo $largestProductId ;?>"><?php echo number_format($largestPrice,2);?></span>
                        </div>
                    </div>
   <?php } ?>
                <div class="row font-bold" style="margin:8px 0px;min-height: 65px;">
                    <div class="col-md-3 text-left">
                        Saves 2.5% with <br> recurring order
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
                        Quantity  <input type="text" class="p-qty" name="number_qty_<?php echo $groupId; ?>" id="number_qty_<?php echo $groupId; ?>" value="1">
                    </div>

                </div>

                </div>
                </div>
                </div>
                <div class="col-md-2"></div>
                <script language="javascript" type="text/javascript">
                    addPrice(<?php echo $groupId ;?>,<?php echo $groupId ;?>);
                    loadCustomeCombo(<?php echo $groupId ;?>);
                </script>

                </form>
            </div>
<?php
        //$largePrice = '';
        }
?>
        <div class="container" style="min-height:200px;">
            <form method="post" action="<?php echo base_url();?>checkout/additems/" />
            <div class="col-md-1">

            </div>
        <div class="col-md-10" style="margin-top: 5px; padding-top:5px;">
            <div class="row" style="border: 1px #c0c0c0 solid;margin-top: 5px; padding-top:5px;">
                <div class="col-md-3">
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
                <div class="col-md-9">
                    <div class="row" style="min-height:60px;">
                        <div class="col-md-6 text-left" >
                            <div class="font-bold"> <?php echo $product['manufacturer_name']; ?> </div>
                            <div class="font-bold">   <?php echo $product['product_name']; ?> </div>
                            <div class="font-bold delivery-date"> <span style="color:#fbb03b;">Next available delivery: <span style="color:#FE5B00;"><?php echo $product['nextDeliveryDate'];?> </span></span></div>
                        </div>
                        <div class="col-md-6 text-right" >
                            <div class="our-price">OUR PRICE <span id="currentPrice_<?php echo $product['group_id']; ?>" style="color:#FE5B00;">  </span>
                            </div>
                            <input type="hidden" name="groupId" id="groupId_<?php echo $product['group_id']; ?>" value="<?php echo $product['group_id']; ?>">
                            <input type="hidden" name="manufacturerId_<?php echo $product['group_id']; ?>" id="manufacturerId_<?php echo $product['group_id']; ?>" value="<?php echo $product['manufacturer_id']; ?>">
                            <button type="submit" name="BUY"  id="btnbuy_<?php echo $product['group_id']; ?>"  value="ADD TO CART" class="btn-add">ADD TO CART</button>
                        </div>
                    </div>
                    <div class="row font-bold" style="border-bottom: 2px solid #fbb03b;">
                        <div class="col-md-4 text-left">
                            Options
                        </div>
                        <div class="col-md-4 text-center">
                            <?php echo ( $product['unit'] == 'lbs' )?"Per Lbs":"" ;?>
                        </div>
                        <div class="col-md-4 text-right">
                            Price
                        </div>
                    </div>
<?php
            $groupId = $product['group_id'];
            //$largePrice = $product['price'];
        $largePrice = '';
        }

                        if( $largePrice < $product['price'] ){
                            $largePrice = $product['price'];// ($product['price']*2) - ($product['price']*2)*.025;
                            $largestProductId = $product['product_id'];
                            $productWeight = $product['weight'];
                            $productUnit = $product['unit'];
                            $classId = $product['class_id'];
                        }

?>
                        <div class="row"  style="border-bottom: 1px solid gainsboro;margin:5px 5px;">

                            <div class="col-md-5 text-left">
                                <input type="radio" name="productid" id="productid_<?php echo $product['group_id'];?>" value="<?php echo $product['product_id'];?>" <?php  echo ($groupId == $product['product_id']?"checked":"");?> onclick="addPrice(<?php echo $product['product_id'] ;?>,<?php echo $product['group_id'] ;?>)" />
                                <?php echo  $product['weight'] ." ".$product['unit'] ;?>
                            </div>
                            <div class="col-md-3 text-center">
                                <?php  if( $product['unit'] == 'lbs' ) {?>
                                    $<?php echo number_format($product['price']/$product['weight'], 2); ?>
                                <?php }?>
                            </div>
                            <div class="col-md-4 text-right">
                                $ <span id="pprice<?php echo $product['product_id'] ;?>"><?php echo number_format($product['price'],2);?></span>
                            </div>
                        </div>

<?php
        $largePrice = $product['price'];
//echo $largePrice." ".$largestProductId;
    }
 //echo $largePrice." ".$largestProductId;

if( $classId == '22' || $classId == '31' ){
    $largestPrice = ($largePrice*2) - ($largePrice*2)*0.025;
?>

                    <div class="row"  style="border-bottom: 1px solid gainsboro;margin:5px 5px;">

                        <div class="col-md-5 text-left">
                            <input type="radio" name="productid" id="productid_<?php echo $largestProductId;?>" value="<?php echo $largestProductId;?>" <?php // echo ($groupId == $product['product_id']?"checked":"");?> onclick="addLPrice(<?php echo $largestProductId ;?>,<?php echo $groupId ;?>);" />
                            <?php echo  $productWeight*2 ." ".$productUnit ." "."( 2 *".$productWeight."-".$productUnit.") *SAVE MORE*" ;?>
                        </div>
                        <div class="col-md-3 text-center">
                            <?php if($productUnit == 'lbs') { ?>
                                $<?php echo number_format($largestPrice/($productWeight*2), 2); ?>
                            <?php  }  ?>
                        </div>
                        <div class="col-md-4 text-right">
                            $ <span id="pLprice<?php echo $largestProductId ;?>"><?php echo number_format($largestPrice,2);?></span>
                        </div>
                    </div>
<?php } ?>
                    <div class="row font-bold" style="margin:8px 0px;min-height: 65px;">
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
                            Quantitys  <input type="text" class="p-qty" name="number_qty_<?php echo $groupId; ?>" id="number_qty_<?php echo $groupId; ?>" value="1">
                        </div>
                        <script language="javascript" type="text/javascript">
                            addPrice(<?php echo $groupId ;?>,<?php echo $groupId ;?>);
                            loadCustomeCombo(<?php echo $groupId ;?>);
                        </script>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-1">

        </div>
       </form>
    </div>
</div>



