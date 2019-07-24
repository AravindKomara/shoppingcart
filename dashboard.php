<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Item Details</h2>
  <i class='fa fa-print' aria-hidden='true'></i>
   Cart (<span id='cart_value'>0</span>)
  <br>
  <table class="table">
    <thead>
      <tr>
        
        <th>ItemName</th>
        <th>ItemCode</th>
        <th>Add to cart</th>
        <th>Delete from cart</th>
        
      </tr>
    </thead>
    <tbody>
        <?php
        if(isset($itemdetails)){
            foreach($itemdetails as $item){
                ?><tr id="item_row<?=$item->itemid?>">
                   <!-- <td><input type='checkbox' calss = '' value="<?=$item->itemid?>" name='checkboxes'></td>-->
        <td><?=$item->item_name?></td>
        <td><?=$item->item_code?></td>
        <td><button class="btn btn-success" id="itemssubmit_button" onclick="addToCart(<?=$item->itemid?>)">Add to cart</button> </td>
        <td><button class="btn btn-success" id="itemssubmit_button"  onclick="delteFromCart(<?=$item->itemid?>)">Delete from cart</button> </td>
      </tr>
           <?php }
        }
        ?>
    
    </tbody>
  </table>
 
 
</div>

</body>
</html>

<script>
     $("#itemssubmit_button").click(function (e) {
        e.preventDefault();
        var itemIDs = [];
        $("input:checkbox:checked").map(function () {
            itemIDs.push($(this).val());
        });
        //alert(orderIDs);
        console.log(itemIDs);
       // return;
      // sample_submission_popup(orderIDs);
      //  $('.loading').show();
     
       
    });
    
    function addToCart(itemId){
        
         $.ajax({
         
       url:"<?=  base_url("index.php/Home/addToCart")?>",
       type:"POST",
       data: {
           itemID:itemId
       },
       
       success:function(response){
           console.log(response);
           response = JSON.parse(response);
           if(response.status == "1"){
               alert('Items are added to cart sucessfully');
              
               //$("#item_row"+itemId).fadeOut();
               $("#cart_value").text(response.cart_count);
             
           }else{
              alert('Items are not added to cart');
               //window.location.reload(); 
           }
       }
    });
    
    }
    
    function delteFromCart(itemId){
        
         $.ajax({
         
       url:"<?=  base_url("index.php/Home/delteFromCart")?>",
       type:"POST",
       data: {
           itemID:itemId
       },
       
       success:function(response){
           console.log(response);
           response = JSON.parse(response);
           if(response.status == "1"){
                alert('Items are deleted from cart sucessfully');
               $("#item_row"+itemId).fadeOut();
               $("#cart_value").text(response.cart_count);
             
           }else{
              alert('Items are not added to cart');
               //window.location.reload(); 
           }
       }
    });
    
    }
    
    
</script>
