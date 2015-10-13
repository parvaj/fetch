<?php
                      //var_dump($classes);
    foreach($departments as $department )
    {
?>
        <div class="brandblock">
            <span class="image" style=" height: 120px; ">
                <a href="<?php echo base_url()."product/products/".$department['department_id'];?>">
                    <img src='../localimages/newanimal_<?php echo $department['department_id'];?>.jpg' height='125' border='0' />
                </a>
            </span>
            <br>
            <span class="brandname" style="padding: 0 0em; width:inherit; ">
                <a href="<?php echo base_url()."product/products/".$department['department_id'];?>">
                    <?php echo $department['department_name'];?>
                </a>
            </span>

        </div>
<?php
    }
?>