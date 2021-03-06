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
    <div class="row">
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
            if(!empty($itemDetails))
            {
            $subtotal = 0;
            $tax = 0;

            foreach($itemDetails as $items ){ ?>
                <div class="row vertical-align" style="margin: 5px 0;border-top:1px solid #fbb03b;padding: 8px;">
                    <div class="col-xs-4 col-md-1">
                        <div style="background-color: #fbb03b;border-radius: 6px;color: #ffffff;">x</div>
                    </div>
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-md-4"> <img class="img-responsive" src="<?php echo base_url();?>img/products1.jpg"> </div>
                            <div class="col-md-8 text-left">
                                <div><?php echo $items['manufacturer_name']; ?></div>
                                <div><b> <?php echo $items['product_name']; ?></b></div><br>
                                <div class="next-delivery-style"> Next Available Delivery </div>
                                <div class="text-color"> <?php echo $items['next_delivery']; ?> </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-color"> $ <?php echo $items['price']; ?></div>
                    </div>
                    <div class="col-md-3">
                        <div> <?php echo $items['qty']; ?></div>
                    </div>
                </div>
    <?php
                $subtotal += $items['price'];
            }
                $tax = $subtotal * 0.0740;
                $total = $subtotal+$tax;
            }?>


        </div>
        <div class="col-md-3 text-left" style="padding-left:50px;">
            <button style="width:60%" name="total" value="" class="btn-add">TOTAL </button><br>
            <div class="cart-summary text-left">
              <span class="cart-text"> SUBTOTAL $<?php echo $subtotal;?> </span><br>
              <span class="cart-text">  TAX  $<?php echo number_format($tax,2);?> </span><br>
              <span class="cart-text"> DELIVERY FEE </span><br>
              <span class="cart-text text-color"> TOTAL $<?php echo number_format($total,2);?> </span>
            </div>
            <button type="button" style="width:60%" name="checkout" value="" class="btn-add checkout-btn">CHECKOUT</button><br>
        </div>
    </div>
</div>

<!--div class="container">
                <div class="row">
                    <div class="col-md-12">
                       <?php
                            echo isset($errorMessage)? $errorMessage:"";
                            echo "Next Delivery:".$customerDelivery;
                            echo "Order No:".$orderNo;
                       ?>
                    </div>
                </div>
                <div class="row" style="background-color: aqua;">
                    <div class="col-md-2">
                        <div> Product Name </div>
                    </div>
                    <div class="col-md-2">
                        <div>Quantity</div>
                    </div>
                    <div class="col-md-2">
                        <div>Price</div>
                    </div>
                    <div class="col-md-2">
                        <div>Delivery Date</div>
                    </div>
                    <div class="col-md-2">
                        <div>Frequency</div>
                    </div>
                </div>


                    <?php
                   // echo "<pre>";
                   // print_r($itemDetails);

                    $deliveryDayShow= "";


                        if(!empty($itemDetails))
                        {
                            $subtotal = 0;

                            foreach($itemDetails as $items ){ ?>
                             <div class="row">
                                <div class="col-md-2">
                                    <div><?php echo $items['product_name']; ?></div>
                                </div>
                                 <div class="col-md-2">
                                    <div>
                                        <select  name=qty_<?php echo $items['item_id']?> id=qty_<?php echo $items['item_id']?> >
                                        <?php
                                            for($i=1; $i<=20;$i++){
                                        ?>
                                                <option value='<?php echo $i;?>' <?php echo $i == $items['qty']?"Selected":"";?> ><?php echo $i;?></option>
                                        <?php
                                            }
                                        ?>
                                         </select>
                                    </div>
                                 </div>
                                 <div class="col-md-2">
                                    <div><?php echo $items['price']; ?></div>
                                 </div>
                                 <div class="col-md-2">
                                     <div>
                                         <select name="deliveryDate_<?php echo $items['item_id']?>" id="deliveryDate_<?php echo $items['item_id']?>">
                                            <?php
                                                foreach($deliveryDayList as $deliveryDay ){
                                            ?>
                                                 <option value='<?php echo $deliveryDay["dateValue"];?>' <?php echo $deliveryDay["dateValue"]==$items['next_delivery']?"Selected":"";?> ><?php echo $deliveryDay["dateDisplay"];?></option>
                                            <?php
                                                }
                                                if($items['frequency_id']==0){
                                            ?>
                                                    <option value='0000-00-00' >Cancel Order</option>
                                            <?php
                                                }
                                            ?>
                                         </select>
                                     </div>
                                 </div>
                                 <div class="col-md-2">
                                     <div>
                                         <select name="frequency_<?php echo $items['item_id']?>" id="frequency_<?php echo $items['item_id']?>">
                                             <?php
                                             foreach($frequencyList as $frequency ){
                                                 ?>
                                                 <option value='<?php echo $frequency["frequency_id"];?>' <?php echo $frequency["frequency_id"]==$items['frequency_id']?"Selected":"";?> ><?php echo $frequency["frequency"];?></option>
                                             <?php
                                             }
                                             if($items['frequency_id']==0){
                                                 ?>
                                                 <option value='0000-00-00' >Cancel Order</option>
                                             <?php
                                             }
                                             ?>
                                         </select>
                                     </div>
                                 </div>
                             </div>
                        <?php
                         $subtotal += $items['price'];
                            }
                    ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <div></div>
                                </div>
                                <div class="col-md-3">
                                    <div></div>
                                </div>
                                <div class="col-md-3">
                                    <div></div>
                                </div>
                                <div class="col-md-3">
                                    <div> Sub total : <?php echo  $subtotal ; ?></div>
                                </div>

                            </div>


                    <?php
                        }
                    ?>

            </div>
