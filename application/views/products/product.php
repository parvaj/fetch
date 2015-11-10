<div class="container-fluid" style="margin: 15px 0 0;">
    <div class="container">
        <div class="col-md-7">
            <div class="row">
                <div class="col-md-12">
                    <div class="choice-title"> <?php echo (!empty($flag)?"So many choices!":$departmentName." "."Stuff"); ?>  </div>
                    <?php   if(empty($flag)){ ?>
                                <div class="home-text3"> select a category or simply browse this <br> page to find the items you are looking for!</div>
                    <?php   } ?>
                </div>
            </div>
            <div class="row" style="margin: 15px 10px;">
                <div class="col-md-4">
                    <table><tr><td>
                    <select name="category" id="category">
                        <option value=''> Search by Category </option>
                        <?php
                            foreach($classes as $class ){
                        ?>
                                <option value="<?php echo $class['class_id'];?>" <?php echo (!empty($urlSegment['classSection']) && $urlSegment['classSection'] == $class['class_id'])?"selected":"" ;?> ><?php echo $class['class_name'];?></option>
                        <?php
                            }
                        ?>
                    </select>
                            </td>
                        </tr>
                        </table>

                </div>
                <div class="col-md-4">
                    <table><tr><td>
                    <select name="brand" id="pp-brand">
                        <option value=''> Search by Brand </option>
                        <?php
                            foreach($brands as $brand ){
                        ?>
                                <option value="<?php echo $brand['manufacturer_id'];?>" <?php echo (!empty($urlSegment['brandSection']) && $urlSegment['brandSection'] == $brand['manufacturer_id'])?"selected":"" ;?> ><?php echo $brand['manufacturer_name'];?> </option>
                        <?php
                            }
                        ?>
                    </select>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4">
                    <select name="petType" id="petType">
                        <option value=''> Search by Sub Class </option>
                    <?php
                        foreach($subClasses as $subClass ) {
                    ?>
                            <option value="<?php echo $subClass['subclass_id'];?>" <?php echo (!empty($urlSegment['subClassSection']) && $urlSegment['subClassSection']== $subClass['subclass_id'])?"selected":"" ;?> > <?php echo $subClass['subclass_name'];?> </option>
                    <?php
                        }
                    ?>
                    </select>
                </div>
            </div>
            <input type="hidden" name="deptId" id="deptId" value="<?php echo $urlSegment['deptSection'];?>">
            <button type="button" style="margin:10px;" id="submit" class="btn-add"> SUBMIT </button>
        </div>
        <div class="col-md-5">
            <?php   if(empty($flag)){ ?>
                        <a href="<?php echo base_url();?>product/pets"><img class="img-responsive img-left" src="<?php echo base_url();?>img/pets/<?php echo $images;?>" alt="<?php echo $departmentName; ?> departments"/></a>
            <?php   }else
                    { ?>
                            <button type="submit" id="department" value="department" class="btn-add target_button" onclick="removeClassId();"><?php echo $departmentName ;?> </button>
                        <?php
                            foreach($classes as $class ) { ?>
                                    <button type="submit" id="classes" value="classes" class="btn-add target_button" onclick="removeClassId();"><?php echo $class['class_name'] ;?> </button>
                        <?php  }
                            foreach($brands as $brand ){ ?>
                                    <button type="submit" id="brands" value="brands" class="btn-add target_button" onclick="removeClassId();"><?php echo $brand['manufacturer_name'] ;?> </button>
                        <?php   }
                    }  ?>
        </div>
    </div>
</div>
<script type="text/javascript">


        $("#submit").click(function(event) { //alert('heloo');
            //event.preventDefault();
            var category = $("#category").val();
            alert(category+'ff');
            var brand = $("#pp-brand").val();
            alert(brand+'ff1');
            var subclass = $("#petType").val();
            alert(subclass);

        });
        /*
            $("#mytest").change(function(){ alert('dxvxc');
                var addd = $("#mytest").val();
                alert(addd);


            });
                jQuery.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>" + "product/products/"+<?php echo $urlSegment['deptSection']; ?>,
                dataType: 'json',
                data: {brandtest: brand, category: category},
                success: function(res) {
                    if (res)
                    {
                        alert(res);
                    }
                }
            });
        });*/
   // });
</script>


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
    $groupId = "";
    $largePrice = "";
    $classId = "";
    $imageLnk = '';
    foreach($products as $product ){

        if($groupId != $product['group_id'] ) {
            //$largePrice = $product['price'];
            if($groupId!=""){
                //echo $largePrice." ".$largestProductId;
                if( $classId == '22' || $classId == '31'  ){
                    $largestPrice = ($largePrice*2) - ($largePrice*2)*0.025;
?>
                    <div class="row">

                        <div class="col-md-5 text-left">
                            <input type="radio" name="productid" id="productid_<?php echo $largestProductId;?>" value="<?php echo $largestProductId;?>" <?php // echo ($groupId == $product['product_id']?"checked":"");?> onclick="addLPrice(<?php echo $largestProductId ;?>,<?php echo $groupId ;?>);" />
                            <?php echo  $productWeight*2 ." ".$productUnit ." "."( 2 *".$productWeight."-".$productUnit.") *SAVE MORE*" ;?>
                        </div>
                        <div class="col-md-3 text-right">
                            <?php if($productUnit == 'lbs') { ?>
                                $<?php echo number_format($largestPrice/($productWeight*2), 2); ?>
                            <?php  }  ?>
                        </div>
                        <div class="col-md-4 text-right">
                            $ <span id="pLprice<?php echo $largestProductId ;?>"><?php echo number_format($largestPrice,2);?></span>
                        </div>
                    </div>
   <?php } ?>
                <div class="row font-bold" style="margin-top:5px;">
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
        <div class="container" style="min-height:200px;margin-top:5px;margin-bottom: 5px;">
            <form method="post" action="<?php echo base_url();?>checkout/additems/" />
            <div class="col-md-1">

            </div>
        <div class="col-md-10">
            <div class="row" style="border: 1px #c0c0c0 solid;padding: 8px;">
                <div class="col-md-3">
                    <?php
                        if( file_exists("http://www.fetchdelivers.com/images/LAR-INV/".$product['img']."") )
                        {
                            $imageLnk = "http://www.fetchdelivers.com/images/".$product['img']."";
                        }
                        else
                        {
                            $imageLnk = "http://www.fetchdelivers.com/localimages/nopicture.jpg";
                        }
                    ?>

                    <a href="<?php echo base_url() . "product/item/" . $product['group_id']; ?>">
                        <img class="img-responsive img-center" src="<?php echo "http://www.fetchdelivers.com/images/".$product['img'].""; ?>" alt="products for fetchdelivers.com">
                    </a>

                    <div class="p-ratings">
                        <img src="<?php echo base_url();?>img/rating0.png"
                             alt="products ratings for fetchdelivers">

                    <div class=""> PRODUCT RATING</div>
                    </div>
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
                    <?php if( ( $product['class_id'] =='22' || $product['class_id'] =='31') && ($customerId < 1 || empty($isNewCustomer))){ ?>
                        <div class="row new-customer">
                            <div class="col-md-12 text-center">
                                <div class="save-new-customer"> New Customers Save 50% Off First Bag of Pet Food </div>
                                <div class="save-new-customer-sec"> Discount will be applied at checkout of your first order</div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="row font-bold" style="border-bottom: 2px solid #fbb03b;">
                        <div class="col-md-5 text-left">
                            Options
                        </div>
                        <div class="col-md-3 text-right">
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
                        <div class="row"  style="border-bottom: 1px solid gainsboro;">

                            <div class="col-md-5 text-left">
                                <input type="radio" name="productid" id="productid_<?php echo $product['group_id'];?>" value="<?php echo $product['product_id'];?>" <?php  echo ($groupId == $product['product_id']?"checked":"");?> onclick="addPrice(<?php echo $product['product_id'] ;?>,<?php echo $product['group_id'] ;?>)" />
                                <?php echo  $product['weight'] ." ".$product['unit'] ;?>
                            </div>
                            <div class="col-md-3 text-right">
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

                    <div class="row"  style="border-bottom: 1px solid gainsboro;">

                        <div class="col-md-5 text-left">
                            <input type="radio" name="productid" id="productid_<?php echo $largestProductId;?>" value="<?php echo $largestProductId;?>" <?php // echo ($groupId == $product['product_id']?"checked":"");?> onclick="addLPrice(<?php echo $largestProductId ;?>,<?php echo $groupId ;?>);" />
                            <?php echo  $productWeight*2 ." ".$productUnit ." "."( 2 *".$productWeight."-".$productUnit.") *SAVE MORE*" ;?>
                        </div>
                        <div class="col-md-3 text-right">
                            <?php if($productUnit == 'lbs') { ?>
                                $<?php echo number_format($largestPrice/($productWeight*2), 2); ?>
                            <?php  }  ?>
                        </div>
                        <div class="col-md-4 text-right">
                            $ <span id="pLprice<?php echo $largestProductId ;?>"><?php echo number_format($largestPrice,2);?></span>
                        </div>
                    </div>
<?php } ?>
                    <div class="row font-bold" style="margin-top:5px;">
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
                            Quantity <input type="text" class="p-qty" name="number_qty_<?php echo $groupId; ?>" id="number_qty_<?php echo $groupId; ?>" value="1">
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



