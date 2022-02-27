<?php
include '../connect.php';

if (isset($_POST['product_type'])) {
    $product_type = $_POST['product_type'];

    $warning = selectOne('warnings', ['product_type' => $product_type]);



?>

    <script>
        tinymce.init({
            selector: '#warning'
        });
    </script>
    <div class="form-group">
        <label for="">Warning</label>
        <textarea name="warning" id="warning" cols="30" rows="10" required><?php echo $warning['warning']; ?></textarea>
    </div>

<?php
}
