<?php

if (isset($_POST['value'])) {
?>
<input type="text" value="<?php echo $_POST['value']; ?>" id="value">
    <script>
        // copy
        function myFunction() {

            var copied = document.getElementById("value");

            // select the text
            copied.select();
            copied.setSelectionRange(0, 99999);

            navigator.clipboard.writeText(copied.value);

            // document.getElementById("<?php //echo "p$key" . $purchaseId; 
                                        ?>").style.backgroundColor = "green";

        }
    </script>
<?php
}
