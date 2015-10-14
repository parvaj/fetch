            <div class="container">
                <div class="row">

                    <?php
                        if(!empty($products)){
                            $groupId="";
                            foreach($products as $product ){
                                if($groupId==""){
                                    $groupId= $product['group_id']

                    ?>
                                    <div class="col-md-7">
                                        <div><?php echo $product['manufacturer_name']; ?></div>
                                        <p><?php echo $product['EXTENDED']; ?></p>
                                        <p><?php echo $product['ingredients']; ?></p>
                                    </div>
                                    <div class="col-md-5">

                                        <img src="" style="width: 320px; height: 225px; border: 1px solid #008080">
                                        <div>next delivery: <?php echo $nextDelivery; ?></div>
                                     </div>
                                    <div class="col-md-12">
                                        <div><?php echo $product['product_name']; ?></div>
                                        <h2>variant</h2>
                    <?php
                                }
                    ?>
                                        <div>
                                            <?php echo $product['weight']." ".$product['unit'];?> &nbsp;&nbsp;&nbsp;&nbsp;  Price: $<?php echo number_format($product['price'],2);?>
                                        </div>
                    <?php
                            }
                    ?>
                                        <div><button name="buy">Add To Cart</button></div>
                                    </div>

                    <?php
                        }
                    ?>
                </div>
            </div>
