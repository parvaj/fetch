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
                        <input type="hidden" name="manufacturerId" id="manufacturerId" value="<?php echo $product['manufacturer_id']; ?>">
                        <div class="font-bold delivery-date"> <span style="color:#fbb03b;">Next available delivery: </span><span style="color:#FE5B00;"><?php echo $nextDelivery; ?></span></div>
                    </div>
                    <div class="col-md-5 text-right">
                        <div class="our-price">OUR PRICE <span id="currentPrice" style="color:#FE5B00;"> <?php echo $product['price']; ?> </span>
                            <input type="hidden" name="productPrice" id="productPrice" value="">
                        </div>
                        <button type="submit" name="BUY" id="btnbuy_<?php echo $product['group_id'];?>"
                                value="ADD TO CART" class="btn-add">ADD TO CART
                        </button>
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
<?php }
} ?>
        <div style="min-height: 100px">
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
        <?php  } ?>
        </div>

        <div class="row" style="margin-top:5px;">
            <div class="col-md-3 text-left">
                Save 2.5% with <br> recurring order
            </div>
            <div class="col-md-2 text-center">
                Recurring Order
            </div>
            <div class="col-md-4 text-left">
                <select name="frequency" id="frequency">
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
            var price = jQuery( "span#pprice"+pid ).html();
            jQuery('#currentPrice').text('$'+price);
            jQuery('input#number_qty').val("1");

        }
        addPrice(<?php echo $productId ;?>);
</script>