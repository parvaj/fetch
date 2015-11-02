<div class="container" style="min-height: 85%;">
    <div class="row">
        <div class="col-md-6">
            <div class="shopping-cart text-right">
                My Shopping Cart
            </div>

        </div>
        <div class="col-md-2">
            <img class="img-responsive" src="<?php echo base_url();?>img/shopping-cart.jpg">
            </div>
        <div class="col-md-4">
            </div>
    </div>
    <?php
    if(!empty($itemDetails)) {
        ?>
        <div class="row" style="min-height:350px;">
            <div class="col-md-1">
            </div>
            <div class="col-md-8">
                <div class="row cart-style">
                    <div class="col-md-4">
                        ITEM
                    </div>
                    <div class="col-md-4">
                        PRICE
                    </div>
                    <div class="col-md-4">
                        QUANTITY
                    </div>
                </div>
                <?php

                $subtotal = 0;
                $tax = 0;

                foreach ($itemDetails as $items) { ?>
                    <div class="row vertical-align" style="margin: 5px 0;border-top:1px solid #fbb03b;padding: 8px;">
                        <div class="col-xs-4 col-md-1">

                                <a href="<?php echo base_url()."checkout/removeItems/".$items['item_id'];?>" style="background-color: #fbb03b;border-radius: 6px;color: #ffffff; width: 20px;">x</a>

                        </div>
                        <div class="col-md-5">
                            <div class="row">
                                <div class="col-md-4"><img class="img-responsive"
                                                           src="http://www.fetchdelivers.com/images/<?php echo $items['img'] ?>">
                                </div>
                                <div class="col-md-8 text-left">
                                    <div><?php echo $items['manufacturer_name']; ?></div>
                                    <div><b> <?php echo $items['product_name']; ?></b></div>
                                    <br>

                                    <div class="next-delivery-style"> Next Available Delivery</div>
                                    <div class="text-color"> <?php echo $items['next_delivery']; ?> </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-color"> $ <?php echo $items['price']; ?></div>
                        </div>
                        <div class="col-md-3">
                            <input type="text" style="text-align: center;" class="p-qty" name="number_qty"
                                   id="number_qty>" value="<?php echo $items['qty']; ?>">
                        </div>
                    </div>
                    <?php
                    $subtotal += $items['price'];
                }
                $tax = $subtotal * 0.0740;
                $total = $subtotal + $tax;
                ?>


            </div>
            <div class="col-md-3 text-left" style="padding-left:50px;">
                <button style="width:60%" name="total" value="" class="btn-add">TOTAL</button>
                <br>

                <div class="cart-summary text-left">
                    <span class="cart-text"> SUBTOTAL $<?php echo $subtotal; ?> </span><br>
                    <span class="cart-text">  TAX  $<?php echo number_format($tax, 2); ?> </span><br>
                    <span class="cart-text"> DELIVERY FEE </span><br>
                    <span class="cart-text text-color"> TOTAL $<?php echo number_format($total, 2); ?> </span>
                </div>
                <button type="button" style="width:60%" name="checkout" id="checkout" value=""
                        class="btn-add checkout-btn"
                        onclick="window.location='<?php echo base_url() ?>checkout/orderSummery'">CHECKOUT
                </button>
                <br>
            </div>
        </div>
        <?php
    }
    else
    {
    ?>
    <div class="row" style="min-height:350px;"><div class="col-md-12"> There is no product in cart!!</div> </div>
    <?php

    }
    ?>
</div>
<?php

if(isset($loginMessage) && $loginMessage==0){
?>
<script>
    $(function(){
        $(".fetch-login").show();
        $("#username").focus();
    });
</script>
    <?php
}
?>