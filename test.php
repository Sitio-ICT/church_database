Faccebook|germany|Another facebook account|www.facebook.com|20|dunce@email.com|asdhsaud

rdp|germany|Another rdpw|12901.3432.43|20|junce|asdhsaud
card|germany|Got a new card|2323-3223-3233-3232|20|20-20|932

12901.3432.43|junce|asdhsaud

<!-- account meta information -->
<?php
if ($purchase['product_type'] == "sms") {
?>
    <div class="form-group">
        <label for="">Number</label>
        <input type="text" class="form-control" id="sms" readonly value="<?php echo $purchase['value']; ?>">
        <button onclick="myFunction()" class="form-control" id="">Copy</button>
    </div>
    <script>
        // copy
        function myFunction() {

            var copied = document.getElementById("sms");

            // select the text
            copied.select();
            copied.setSelectionRange(0, 99999);

            navigator.clipboard.writeText(copied.value);

            // document.getElementById("<?php //echo "p$key" .$purchaseId; 
                                        ?>").style.backgroundColor = "green";

        }
    </script>
<?php
}
