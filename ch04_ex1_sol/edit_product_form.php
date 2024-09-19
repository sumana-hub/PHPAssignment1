<?php
require('database.php');

// Get product and category IDs
$product_id = filter_input(INPUT_GET, 'product_id', FILTER_VALIDATE_INT);
$category_id = filter_input(INPUT_GET, 'category_id', FILTER_VALIDATE_INT);

// Fetch product data
$queryProduct = 'SELECT * FROM products WHERE productID = :product_id';
$statement = $db->prepare($queryProduct);
$statement->bindValue(':product_id', $product_id);
$statement->execute();
$product = $statement->fetch();
$statement->closeCursor();

// Fetch categories for dropdown
$queryCategories = 'SELECT * FROM categories ORDER BY categoryID';
$statement = $db->prepare($queryCategories);
$statement->execute();
$categories = $statement->fetchAll();
$statement->closeCursor();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Edit Product</title>
    <link rel="stylesheet" href="main.css">
</head>

<body>
    <header><h1>Edit Product</h1></header>
    <main>
        <form action="update_product.php" method="post" id="edit_product_form">
            <input type="hidden" name="product_id" value="<?php echo $product['productID']; ?>">

            <label>Category:</label>
            <select name="category_id">
                <?php foreach ($categories as $category) : ?>
                    <option value="<?php echo $category['categoryID']; ?>"
                        <?php if ($category['categoryID'] == $product['categoryID']) echo 'selected'; ?>>
                        <?php echo $category['categoryName']; ?>
                    </option>
                <?php endforeach; ?>
            </select><br>

            <label>Code:</label>
            <input type="text" name="code" value="<?php echo $product['productCode']; ?>"><br>

            <label>Name:</label>
            <input type="text" name="name" value="<?php echo $product['productName']; ?>"><br>

            <label>List Price:</label>
            <input type="text" name="price" value="<?php echo $product['listPrice']; ?>"><br>

            <label>&nbsp;</label>
            <input type="submit" value="Update Product"><br>
        </form>
        <p><a href="index.php">View Product List</a></p>
    </main>
</body>

</html>
