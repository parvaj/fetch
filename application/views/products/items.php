<div class="container-fluid" style="min-height:480px;">
<form method="post" action="<?php echo base_url();?>checkout/additems/"/>
<?php
if(!empty($products)) {
    $groupId="";
    $productId ="";
    foreach ($products as $product) {
        if ($groupId == "") {
            $groupId = $product['group_id'];
            $productId = $product['product_id'];
?>
<div class="container" >
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-3">
                <a href="<?php echo base_url() . "product/item/" . $product['group_id']; ?>">
                    <img class="img-responsive img-center" src="http://www.fetchdelivers.com/images/LAR-INV/<?php echo $product['img']?>" alt="products for fetchdelivers">
                </a>
                <div class="p-ratings">
                    <img src="<?php echo base_url();?>img/rating0.png" alt="products ratings for fetchdelivers">
                </div>
                <div class=""> PRODUCT RATING </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-7 text-left" >
                        <div class="font-bold"> <?php echo $product['manufacturer_name']; ?> </div>
                        <div class="font-bold"> <?php echo $product['product_name']; ?> </div>
                        <input type="hidden" name="manufacturerId_<?php echo $product['group_id'];?>" id="manufacturerId" value="<?php echo $product['manufacturer_id']; ?>">
                        <input type="hidden" name="groupId" id="groupId" value="<?php echo $product['group_id']; ?>">
                        <div class="font-bold delivery-date"> <span style="color:#fbb03b;">Next available delivery: </span><span style="color:#FE5B00;"><?php echo $nextDelivery; ?></span></div>
                    </div>
                    <div class="col-md-5 text-right">
                        <div class="our-price">OUR PRICE <span id="currentPrice" style="color:#FE5B00;"> <?php //echo $product['price']; ?> </span>
                            <input type="hidden" name="productPrice" id="productPrice" value="">
                        </div>
                        <button type="submit" name="BUY" id="btnbuy_<?php echo $product['group_id'];?>"
                                value="ADD TO CART" class="btn-add">ADD TO CART
                        </button>
                    </div>
                </div>
                <?php if( ( $product['class_id'] =='22' || $product['class_id'] =='31') && ($customerId < 1 || empty($isNewCustomer))){ ?>
                    <div class="row new-customer">
                        <div class="col-md-12 text-center ">
                            <div class="save-new-customer"> New Customers Save 50% Off First Bag of Pet Food </div>
                            <div class="save-new-customer-sec"> Discount will be applied at checkout of your first order</div>
                        </div>
                    </div>
                <?php } ?>
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
<?php }
} ?>
        <div style="min-height: 80px">
        <?php    foreach ($products as $productDetails) {
        ?>
            <div class="row" style="border-bottom: 1px solid gainsboro;margin-top:5px;">
                <div class="col-md-4 text-left">
                    <input type="radio" name="productid" id="productid" value="<?php echo $productDetails['product_id'];?>" <?php echo ($productId == $productDetails['product_id']?"checked":"");?> onclick="addPrice(<?php echo $productDetails['product_id'] ;?>)" />
                    <?php echo  $productDetails['weight'] ." ".$productDetails['unit'] ;?>
                </div>
                <div class="col-md-4 text-center">
                    <?php  if( $productDetails['unit'] == 'lbs' ) {?>
                        $ <?php echo number_format($productDetails['price']/$productDetails['weight'],2);?>
                    <?php }?>
                </div>
                <div class="col-md-4 text-right">
                    $ <span id="pprice<?php echo $productDetails['product_id'] ;?>"><?php echo number_format($productDetails['price'],2);?></span>
                </div>
            </div>
        <?php  }
                if(!empty($largestBagOffer))
                    {
                        foreach($largestBagOffer as $largeffer)
                        {
                            $largestPrice = ($largeffer['price']*2)-(($largeffer['price']*2)*.025);
                            ?>
                            <div class="row" style="border-bottom: 1px solid gainsboro;margin-top:5px;">
                                <div class="col-md-4 text-left">
                                    <input type="radio" name="productid" id="productid" value="<?php echo $largeffer['product_id'];?>" onclick="addLPrice(<?php echo $largeffer['product_id'] ;?>,<?php echo $largeffer['group_id'] ;?> );" />
                                    <?php echo  $largeffer['weight']*2 ." ".$largeffer['unit'] ." "."( 2 *".$largeffer['weight']."-".$largeffer['unit'].") *SAVE MORE*" ;?>
                                </div>
                                <div class="col-md-4 text-center">
                                    <?php  if( $largeffer['unit'] == 'lbs' ) {?>
                                        $ <?php echo number_format($largestPrice/($largeffer['weight']*2),2);?>
                                    <?php }?>
                                </div>
                                <div class="col-md-4 text-right">
                                    $ <span id="pLprice<?php echo $largeffer['product_id'] ;?>"><?php echo number_format((($largeffer['price']*2)-(($largeffer['price']*2)*.025)),2);?></span>
                                </div>
                            </div>
        <?php           }
                    }
                ?>


        </div>

        <div class="row font-bold" style="margin-top:5px;">
            <div class="col-md-3 text-left">
                Save 2.5% with <br> recurring order
            </div>
            <div class="col-md-2 text-center">
                Recurring Order
            </div>
            <div class="col-md-4 text-left">
                <select name="frequency_<?php echo $product['group_id']; ?>" id="frequency_<?php echo $product['group_id']; ?>">
                <?php
                    foreach($frequency as $frequencies){
                ?>
                    <option value="<?php echo $frequencies['frequency_id'];?>" <?php echo  ($frequencies['list_order']==2)?"selected":"" ;?> > <?php echo $frequencies['frequency'];?> </option>
                <?php } ?>
               </select>
            </div>
            <div class="col-md-3 text-right">
                Quantity  <input type="text" class="p-qty" name="number_qty_<?php echo $product['group_id']; ?>" id="number_qty_<?php echo $product['group_id']; ?>" value="1">
            </div>
        </div>
    <div class="row">
        <div class="col-xs-12 col-md-12" >
            <div style="padding-top:7px;">
                <span id="about_tab" style="float:left; text-align:center; width:195px;background-color:#fad49f; vertical-align:bottom;"><a name="acc_tab" id="acc_tab" onclick="showtab(0)" href='javascript:void(0);'  style="float:left; width:135px;color:#000000;font-size:10px;font-weight: bold">ABOUT</a></span>
                <span id="ingrediants_tab" style="float:left; text-align:center; width:220px;  background-color:#fbb03b; vertical-align:bottom;"><a name="acc_tab" id="acc_tab" onclick="showtab(1)" href='javascript:void(0);'  style="float:left; width:140px;color:#000000;font-size:10px;font-weight: bold">INGREDIENTS</a></span>
                <span id="guaranted_tab" style="float:left; text-align:center; width:240px;  background-color:#f4921f; vertical-align:bottom;"><a name="acc_tab" id="acc_tab" onclick="showtab(2)" href='javascript:void(0);'  style="float:left; width:200px;color:#000000;font-size:10px;font-weight: bold">GUARANTED ANALYSIS</a></span>
                <div id="aboutinfo" style="background-color:#fad49f;height:auto;border-radius: 10px;"> <div class="text-left" style="padding:30px 10px 10px 14px;"><span itemprop="description"><?php echo  $product['EXTENDED']; ; ?></span></div></div>
                <div id="ingrediantsinfo" style="background-color:#fcb03b;height:auto;display:none;border-radius: 10px;"> <div class="text-left"style="padding:30px 10px 10px 14px;"><?php echo htmlentities(stripslashes($product['ingredients'])); ?> </div></div>
                <div id="guarantedinfo" style="background-color:#f4921f;height:auto;display:none;border-radius: 10px;"> <div class="text-left" style="padding:30px 10px 10px 14px;"><?php echo htmlentities(stripslashes($product['analysis'])); ?></div></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class=" col-xs-12 col-md-12" >
            <div style="height:100px;background-color:#9191c7;border-radius:12px;margin-top:12px;padding-top:5px;">
                <div style="text-align:center;font-weight:bold;">CUSTOMER REVIEWS</div>
                <!--div style="height:30px;padding:10px 25px;overflow:scroll;overflow-x:hidden;">
                            <?php
                //$sql = "select * from comments where product_id='".dbsafe($productId)."'";
                // $result = mysql_query($sql);
                // while($rowcomments = mysql_fetch_array($result)){  ?>
                                <p style="padding:10px 0px;font-size:12px;">"<?php //echo $rowcomments['comments'];?>" <?php //echo "- ".$rowcomments['first_name']." ".$rowcomments['city'] ;?></p>
                            <?php //	} 	?>
                        </div-->
            </div>
        </div>
    </div>
    <div class="row">
        <div class=" col-xs-12 col-md-12" >
            <div style="float:left;background-color:#b3b3d9;border-radius:12px;margin:12px 0;padding-top:5px;">
                <div style="text-align:center;font-weight:bold;">WRITE A REVIEW!</div>
                <div style="float:left;">
                    <input type="text" placeholder="Enter your comments here." id="comments" style="width:828px;height:50px;background-color:#BEBEE2;border:none;font-size:13px;padding-left:27px;" name="comments" value=""/>
                </div>
                <div>
                    <button type="button" name="BUY" id="btnbuy_1055" value="add-comments" class="btn-add"> Submit </button>

                    <!--button name="btnsubmit12"  type="button" style="background-color:#FFFFFF;color:#000000;border-radius:5px;" onclick="addcomments();">Submit</button-->
                </div>
            </div>
        </div>
    </div>
    </div>

</div>
</div>

</div>
<?php
}
?>
    <form>
</div>
    <script type="text/javascript">
        function addPrice(pid){
            var price = $( "span#pprice"+pid ).html();
            $('#currentPrice').text('$ '+price);
            $('input#number_qty').val("1");
        }
        function addLPrice(productId){
            var price = $( "#pLprice"+productId ).html();
            //alert(price);
            $("#currentPrice").text('$ '+price);
        }
        addPrice(<?php echo $productId ;?>);
      //  addLPrice(<?php echo $productId ;?>);
        loadCustomeCombo(<?php echo $groupId ;?>);
        showtab(0);
    </script>