<div class="container-fluid" style="margin: 15px 0 0;">
    <?php
    if(!empty($products)) {
        $groupId="";
        foreach ($products as $product) {
            if ($groupId == "") {
                $groupId = $product['group_id']

                ?>
                <div class="container" >
                <div class="col-md-2">

                </div>
                <div class="col-md-8">
                <div class="row">
                <div class="col-md-3">

                    <a href="<?php echo base_url() . "product/item/" . $product['group_id']; ?>">
                        <img class="img-responsive img-center" src="<?php echo base_url();?>img/products1.jpg"
                             alt="products for fetchdelivers">
                    </a>

                    <div class="p-ratings">
                        <img src="<?php echo base_url();?>img/rating0.png"
                             alt="products ratings for fetchdelivers">
                    </div>
                    <div class=""> product rating</div>
                </div>
                <div class="col-md-9">
                <div class="row">
                    <div class="col-md-7 text-left" >
                        <div class=""> <?php echo $product['product_name']; ?> </div>
                        <div class=""> <?php echo $product['manufacturer_name']; ?> </div>
                        <div class="font-bold"> Available Delivery Date: <?php echo $nextDelivery; ?></div>
                    </div>
                    <div class="col-md-5 text-right">
                        <div class="our-price">OUR PRICE <span
                                style="color:#FE5B00;">$<?php echo number_format($product['price'], 2);?> </span>
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
                        Per Lbs
                    </div>
                    <div class="col-md-4 text-right">
                        Price
                    </div>
                </div>
            <?php }

        }

            foreach ($products as $productDetails) {



        ?>

                            <div class="row">
                                <div class="col-md-4 text-left">
                                   <?php echo  $productDetails['weight'] ;?>
                                </div>
                                <div class="col-md-4 text-center">
                                   <?php echo $productDetails['unit'];?>
                                </div>
                                <div class="col-md-4 text-right">
                                    $<?php echo number_format($productDetails['price'],2);?>
                                </div>
                            </div>
                  <?php  } ?>

                        </div>

                    </div>
                </div>
                <div class="col-md-2">

                </div>
            </div>
    <?php
        }
    ?>
</div>
