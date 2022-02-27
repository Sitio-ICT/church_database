<?php
include("../../connect.php");

if(!empty($_POST['product_name'])) 
{
    $product_name = $_POST['product_name'];
    $product_type = $_POST['product_type'];

    $products = selectAllLike('products', ['product_name' => $product_name, 'product_type' => $product_type]);

    if(mysqli_num_rows($products) > 0) 
    {
        foreach($products as $product) : 
            $product_names[] = $product['product_name'];
        endforeach;

        $product_names = array_unique($product_names);

        $output = "<ul class='list-group'>";

        foreach($product_names as $product_name) : 
            $output .= "<li class='list-group-item'>".$product_name."</li>";
        endforeach;
    
        $output .= "</ul>";
    
        echo $output;
    }
}

if(isset($_POST["existing_product_name"]))  
{
    $product_name = $_POST['existing_product_name'];
    
    $output =   
            "<tr>
                <td>
                    <div style='position: relative;'>
                        <input type='text' id='search-product-name' placeholder='Search...'>
                        <div id='product-name-list'></div>
                    </div>
                </td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
    ";
                            
    $products = selectAll('products', ['product_name' => $product_name]);

    foreach($products as $product) :
        
    $output .= "
        <tr>    
            <td id='product-type' style='display: none'>".$product['product_type']."</td>
            <td>".$product['product_name']."</td>
            <td>".$product['description']."</td>
            <td>".$product['country']."</td>
            <td>
                <div style='float:left'>
                    ".$product['price']."
                </div>
                <div style='float:right'>
    ";
                    if($product['product_type'] == 'rdp') { 
    $output .= "
                    <a href='../functions/business/buy.php?buy=$product[id]' class='btn btn-primary'>Request</a>
    ";
                    } else {
    $output .= "
                    <a href='../functions/business/buy.php?buy=$product[id]' class='btn btn-primary'>Buy</a>
    ";
                    }
    $output .= "
                </div>
            </td>
        </tr>
    ";

    endforeach;

    $output .= "
    <script>        
        $(document).ready(function() {
            $('#search-product-name').on('change keyup paste', function() {
                var product_name = $(this).val();
                var product_type = $('#product-type').html();
                
                $.ajax({
                    url: '../functions/system/ajax_functions/find_product.php',
                    method: 'POST',
                    data: {
                        product_name: product_name,
                        product_type: product_type
                    },
                    success: function(data) {
                        $('#product-name-list').html(data);
                        $('#product-name-list').show();
                    }
                })
                
            });
    
            $('#product-name-list').on('click dblclick', 'li', function() {    
                var product_name = $(this).text();
                $('#product-name-list').fadeOut();
    
                $.ajax({  
                    url:'../functions/system/ajax_functions/find_product.php',  
                    method: 'POST',
                    data: {
                        existing_product_name: product_name,
                    },
                    success:function(data) {
                        $('#tbody-product').html(data);
                    }
                })
            });
        });
    </script>
    ";

    echo $output;
}
