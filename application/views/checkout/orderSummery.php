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
                <?php
                    $taxRate = number_format($customerDetails[0]['combinedrate'],5);
                    echo $customerDetails[0]['firstname']." ".$customerDetails[0]['surname']."<br />";
                    echo $customerDetails[0]['address']." ".$customerDetails[0]['unit']."<br />";
                    echo $customerDetails[0]['city']." ".$customerDetails[0]['state']." ".$customerDetails[0]['zipcode'];
                ?>
                <br /><a href="#" style="color: #990000; font-weight: bold;">(edit)</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="customer-info text-center">
                BILLING INFo
            </div>
            <div class="text-center">
                <?php
                    echo $customerDetails[0]['firstname']." ".$customerDetails[0]['surname']."<br />";
                    echo $customerDetails[0]['address2']." ".$customerDetails[0]['unit2']."<br />";
                    echo $customerDetails[0]['city2']." ".$customerDetails[0]['state2']." ".$customerDetails[0]['zip2'];
                ?>
                <br /><a href="#" style="color: #990000; font-weight: bold;">(edit)</a>
            </div>

        </div>
        <div class="col-md-4">
            <div class="customer-info text-center">
                CREDIT CARD INFo
            </div>
            <div class="text-center">
                <?php
                    echo $customerDetails[0]['cc_type']."<br />";
                    echo "************".$customerDetails[0]['cc4']."<br /> ".substr($customerDetails[0]['exp_enc'], 0,2)."/".substr($customerDetails[0]['exp_enc'], 2,2);
                ?>
                <br /><a href="#" style="color: #990000; font-weight: bold;">(edit)</a>
            </div>

        </div>

    </div>
    <?php
    if(!empty($itemDetails)) {
        $subtotal = 0;
        $tax = 0;
    ?>
        <div class="row">
            <div class="customer-info text-center">
                This products will be delivered on
                <?php
                    $tmpDate = strtotime($itemDetails[0]['next_delivery']);
                    $currentTmpDate = strtotime(date("Y-m-d"));
                    $dayRemaining = $tmpDate - $currentTmpDate;
                    $dno = round($dayRemaining / 86400 )==1?round($dayRemaining / 86400 )." Day":round($dayRemaining / 86400 )." Days";
                    $sDeliveryDate_day = date("l, m/d/Y",$tmpDate)." (".$dno.")";

                    echo $sDeliveryDate_day ;
                ?>
            </div>
        </div>

        <div class="row" style="border-bottom:1px solid #fbb03b;">
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
                DELIVERY DATE
            </div>
            <div class="col-md-2">
                FREQUENCY
            </div>
            <div class="col-md-1">
                REMOVE
            </div>
        </div>

    <?php

    foreach ($itemDetails as $items){
        if($tmpDate != strtotime($items['next_delivery']))
        {
        ?>

        <div class="row">
            <div class="customer-info text-center">
                This products will be delivered on <?php
                $tmpDate = strtotime($items['next_delivery']);
                $currentTmpDate = strtotime(date("Y-m-d"));
                $dayRemaining = $tmpDate - $currentTmpDate;
                $dno = round($dayRemaining / 86400 )==1?round($dayRemaining / 86400 )." Day":round($dayRemaining / 86400 )." Days";

                $sDeliveryDate_day = date("l, m/d/Y",$tmpDate)." (".$dno.")"; //date("m-d-Y (l)",$tmpDate);

                echo $sDeliveryDate_day ;?>
            </div>
        </div>

        <div class="row" style="border-bottom:1px solid #fbb03b;">
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
                DELIVERY DATE
            </div>
            <div class="col-md-2">
                FREQUENCY
            </div>
            <div class="col-md-1">
                REMOVE
            </div>
        </div>


    <?php

        }
    ?>
        <div class="row vertical-align" style="border-bottom:1px solid #fbb03b;">

            <div class="col-md-3 ">
                <div class="row">
                    <div class="col-md-12 text-left">
                        <div><?php echo $items['manufacturer_name']; ?></div>

                        <b><?php echo $items['product_name']; ?></b>
                    </div>
                </div>

            </div>
            <div class="col-md-1">
                <input type="text" class="cart-qty" name="number_qty_<?php echo $items['item_id']; ?>"   id="number_qty_<?php echo $items['item_id']; ?>" value="<?php echo $items['qty']; ?>" onchange="updateOrderItem(<?php echo $items["item_id"];?>)">

            </div>

            <div class="col-md-2">
                <span class="font-bold"> $ <?php echo $items['price']; ?></span>
            </div>
            <div class="col-md-2">
                <span class="font-bold"> $ <?php echo $items['price'] * $items['qty']; ?></span>
            </div>

            <div class="col-md-2">

                <select name="deliveryDate_<?php echo $items['item_id'] ?>" id="deliveryDate_<?php echo $items['item_id']; ?>" onchange="updateOrderItem(<?php echo $items["item_id"];?>)">
                    <?php
                    foreach ($deliveryDayList as $deliveryDay) {
                    ?>
                        <option value='<?php echo $deliveryDay["dateValue"]; ?>' <?php echo $deliveryDay["dateValue"] == $items['next_delivery'] ? "Selected" : ""; ?> ><?php echo $deliveryDay["dateDisplay"]; ?></option>
                    <?php
                    }
                    if ($items['frequency_id'] == 0) {
                    ?>
                        <option value='0000-00-00'>Cancel Order</option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-2">
                <select name="frequency_<?php echo $items['item_id'] ?>" id="frequency_<?php echo $items['item_id'] ?>" onchange="updateOrderItem(<?php echo $items["item_id"];?>)">
                    <?php
                    foreach ($frequencyList as $frequency) {
                        ?>
                        <option value='<?php echo $frequency["frequency_id"]; ?>' <?php echo $frequency["frequency_id"] == $items['frequency_id'] ? "Selected" : ""; ?> ><?php echo $frequency["frequency"]; ?></option>
                        <?php
                    }
                    if ($items['frequency_id'] == 0) {
                        ?>
                        <option value='0000-00-00'>Cancel Order</option>
                        <?php
                    }
                    ?>
                </select>

            </div>
            <div class="col-md-1">
                <a href="<?php echo base_url()."checkout/removeItems/".$items['item_id'];?>" style="background-color: #fbb03b;border-radius: 6px;color: #ffffff; width: 20px;">x</a>
            </div>

        </div>
        <script type="text/javascript">
            loadCustomeCombo(<?php echo $items['item_id'] ;?>);
            loadDeliveryDate(<?php echo $items['item_id'] ;?>);
        </script>

    <?php
        $subtotal += $items['price'] * $items['qty'];
    }
    $tax = $subtotal * $taxRate;
    $total = $subtotal + $tax + $deliveryFee;
    ?>


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
                    <input type="radio" name="cardName" id="cardName" value="Master Card"/> Master <br>
                    <input type="radio" name="cardName" id="cardName" value="Master Card"/> American Express <br>
                    <input type="radio" name="cardName" id="cardName" value="Master Card"/> Discover <br>
                </span>
            </div>
            <div class="col-md-2">
                <span>
                    <input type="text" class="card-info-box" name="customerCardName" id="customerCardName" value=""/></br>
                    <input type="text" class="card-info-box" name="customerCardName" id="customerCardName" value=""/></br>
                    <input type="text" class="card-info-box" name="customerCardName" id="customerCardName" value=""/></br>
                    <input type="text" class="card-info-box" name="customerCardName" id="customerCardName" value=""/></br>
                </span>
            </div>
            <div class="col-md-2">
                <img class="img-responsive" src="http://localhost/fetch/img/account_fish.jpg">
            </div>
            <div class="col-md-4 font-bold">
                <div style="">
                    <div style="float: left;margin: 8px 22px;">Enter Discount Code</div>
                    <input type="text" class="discount-info-box" name="customerCardName" id="customerCardName" value=""/>
                    <button name="total" value="" class="btn-discount">APPLY</button>
                </div>
                </br>
                <div style="">
                    <div style="width:50%;float: left;margin-top: -10px;"> Available <br> Gift Certificate Credit</div>
                    <input type="text" class="discount-info-box" name="customerCardName" id="customerCardName" value=""/>
                    <button name="total" value="" class="btn-discount">APPLY</button>
                </div>
                </br>
                <div style="">
                    <div style="width:50%;float: left;margin-top: -10px;">Available <br> Account Credit</div>
                    <input type="text" class="discount-info-box" name="customerCardName" id="customerCardName" value=""/>
                    <button name="total" value="" class="btn-discount">APPLY</button>
                </div>
                </br>
            </div>
            <div class="col-md-2 text-left">
                <button style="width:100%" name="total" value="" class="btn-add">TOTAL</button>
                <br>

                <div class="cart-summary ">
                    <span class="cart-text"> SUBTOTAL $<?php echo $subtotal; ?> </span><br>
                    <span class="cart-text">  TAX  $<?php echo number_format($tax, 2); ?> </span><br>
                    <span class="cart-text"> DELIVERY FEE $<?php echo number_format($deliveryFee,2); ?> </span><br>
                    <?php
                        if($foodDiscount > 0){
                    ?>
                            <span class="cart-text"> FOOD DISCOUNT $<?php echo number_format($foodDiscount,2); ?> </span><br>
                    <?php
                            $total = $total-$foodDiscount;
                        }

                        if($recurringDiscount > 0){
                    ?>
                            <span class="cart-text"> Recurring DISCOUNT $<?php echo number_format($recurringDiscount,2); ?> </span><br>
                    <?php
                            $total = $total-$recurringDiscount;
                        }
                    ?>
                    <span class="cart-text text-color"> TOTAL $<?php echo number_format($total, 2); ?> </span>
                </div>
                <button type="button" style="width:100%" name="checkout" id="checkout" value=""
                        class="btn-add checkout-btn"
                        onclick="window.location='<?php echo base_url() ?>checkout/orderSummery'">CONFIRM
                </button>
                <br>

            </div>
        </div>
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
