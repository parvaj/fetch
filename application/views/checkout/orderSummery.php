<div class="container" style="min-height: 85%;">
    <div class="row">
        <div class="col-md-12">
            <div class="shopping-cart text-center">
                Order Summery
            </div>

        </div>

    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="customer-info text-center">
                SHIPPING INFo
            </div>
            <div class="text-center">
                Customer Name
                Addres Line 1<br/>
                Addres Line 2<br/>
            </div>
        </div>
        <div class="col-md-4">
            <div class="customer-info text-center">
                BILLING INFo
            </div>
            <div class="text-center">
                Customer Name
                Addres Line 1<br/>
                Addres Line 2<br/>
            </div>

        </div>
        <div class="col-md-4">
            <div class="customer-info text-center">
                CREDIT CARD INFo
            </div>
            <div class="text-center">
                Customer Name
                Addres Line 1<br/>
                Addres Line 2<br/>
            </div>

        </div>

    </div>
    <div class="row">
        <br>
        </div>

          <div class="row cart-style">
                <div class="col-md-3">
                    ITEM
                </div>
                <div class="col-md-1">
                    QTY
                </div>
                <div class="col-md-1">
                    UNIT PRICE
                </div>
              <div class="col-md-2">
                  SUBTOTAL
              </div>
                <div class="col-md-2">
                    <div>DELIVERY DATE</div>
                </div>
                <div class="col-md-2">
                    <div>FREQUENCY</div>
                </div>
              <div class="col-md-1">
                  <div>REMOVE</div>
              </div>
          </div>

            <?php
            if(!empty($itemDetails))
            {
            $subtotal = 0;
            $tax = 0;

            foreach($itemDetails as $items ){ ?>
                <div class="row vertical-align" style="margin: 5px 0;border-top:1px solid #fbb03b;">

                    <div class="col-md-2 text-left">
                        <div class="row">
                            <div class="col-md-12"><?php echo $items['manufacturer_name']; ?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-12"><b><?php echo $items['product_name']; ?></b></div>
                        </div>

                    </div>
                    <div class="col-md-1">
                        <div><input type="text" class="cart-qty" name="number_qty_<?php echo $items['product_id']; ?>" id="number_qty_<?php echo $items['product_id']; ?>; ?>" value="<?php echo $items['qty'];?>"></div>

                    </div>

                    <div class="col-md-2">
                        <div class="font-bold"> $ <?php echo $items['price']; ?></div>
                    </div>
                    <div class="col-md-2">
                        <div class="font-bold"> $ <?php echo $items['price'] * $items['qty']; ?></div>
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
                    <div class="col-xs-4 col-md-1">
                        <div style="background-color: #fbb03b;border-radius: 6px;color: #ffffff;">x</div>
                    </div>

                </div>
                <script type="text/javascript">
                    loadCustomeCombo(<?php echo $items['item_id'] ;?>);
                    loadDeliveryDate(<?php echo $items['item_id'] ;?>);
                </script>

    <?php
                $subtotal += $items['price'];
            }
                $tax = $subtotal * 0.0740;
                $total = $subtotal+$tax;
            }?>



    <div class="row">
        <div class="col-md-12 text-left">
            <div class="card-info">
                New Credit Card Info
            </div>
        </div>
    </div>
        <div class="row">
            <div class="col-md-2 text-left">
                <span>
                    <input type="radio" name="cardName" id="cardName" value="Visa"/> Visa <br>
                    <input type="radio" name="cardName" id="cardName" value="Master Card" /> Master <br>
                    <input type="radio" name="cardName" id="cardName" value="Master Card" /> American Express <br>
                    <input type="radio" name="cardName" id="cardName" value="Master Card" /> Discover <br>
                </span>
             </div>
            <div class="col-md-2">
                <span>
                    <input type="text" class="card-info-box" name="customerCardName" id="customerCardName" value="" /></br>
                    <input type="text" class="card-info-box" name="customerCardName" id="customerCardName" value="" /></br>
                    <input type="text" class="card-info-box" name="customerCardName" id="customerCardName" value="" /></br>
                    <input type="text" class="card-info-box" name="customerCardName" id="customerCardName" value="" /></br>
                </span>
            </div>
            <div class="col-md-2">
                <img class="img-responsive" src="http://localhost/fetch/img/account_fish.jpg">
            </div>
            <div class="col-md-4 font-bold">
                <div style=""><div style="float: left;margin: 8px 22px;">Enter Discount Code </div> <input type="text" class="credit-info-box" name="customerCardName" id="customerCardName" value="" /></div></br>
                <div style=""><div style="width:50%;float: left;margin-top: -10px;"> Available <br> Gift Certificate Credit </div> <input type="text" class="credit-info-box" name="customerCardName" id="customerCardName" value="" /></div></br>
                <div style=""> <div style="width:50%;float: left;margin-top: -10px;">Available <br> Account Credit</div>  <input type="text" class="credit-info-box" name="customerCardName" id="customerCardName" value="" /></div></br>
            </div>
            <div class="col-md-2 text-left">
                <button style="width:100%" name="total" value="" class="btn-add">TOTAL </button><br>
                <div class="cart-summary ">
                    <span class="cart-text"> SUBTOTAL $<?php echo $subtotal;?> </span><br>
                    <span class="cart-text">  TAX  $<?php echo number_format($tax,2);?> </span><br>
                    <span class="cart-text"> DELIVERY FEE </span><br>
                    <span class="cart-text text-color"> TOTAL $<?php echo number_format($total,2);?> </span>
                </div>
                <button type="button" style="width:100%" name="checkout" id="checkout" value="" class="btn-add checkout-btn" onclick="window.location='<?php echo base_url()?>checkout/orderSummery'">CONFIRM</button><br>

            </div>
        </div>


                <!--div class="text-right" style="padding-left:50px;">
                    <button style="width:25%" name="total" value="" class="btn-add">TOTAL </button><br>
                    <div class="cart-summary text-right">
                        <span class="cart-text"> SUBTOTAL $<?php echo $subtotal;?> </span><br>
                        <span class="cart-text">  TAX  $<?php echo number_format($tax,2);?> </span><br>
                        <span class="cart-text"> DELIVERY FEE </span><br>
                        <span class="cart-text text-color"> TOTAL $<?php echo number_format($total,2);?> </span>
                    </div>
                    <button type="button" style="width:25%" name="checkout" id="checkout" value="" class="btn-add checkout-btn" onclick="window.location='<?php echo base_url()?>checkout/orderSummery'">CHECKOUT</button><br>
                </div-->
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
