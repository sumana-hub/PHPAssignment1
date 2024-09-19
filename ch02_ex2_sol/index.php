<?php 
    // Initialize variables
    $investment = '';
    $interest_rate = '';
    $years = '';
    $error_message = '';
    $future_value_f = '';

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the data from the form
        $investment = filter_input(INPUT_POST, 'investment', FILTER_VALIDATE_FLOAT);
        $interest_rate = filter_input(INPUT_POST, 'interest_rate', FILTER_VALIDATE_FLOAT);
        $years = filter_input(INPUT_POST, 'years', FILTER_VALIDATE_INT);

        // Validate the input
        if ($investment === FALSE || $investment <= 0) {
            $error_message .= 'Investment must be a valid number greater than zero.<br>';
        } 
        if ($interest_rate === FALSE || $interest_rate <= 0 || $interest_rate > 15) {
            $error_message .= 'Interest rate must be a valid number between 0 and 15.<br>';
        }
        if ($years === FALSE || $years <= 0 || $years > 30) {
            $error_message .= 'Years must be a valid number between 1 and 30.<br>';
        }

        // If there are no errors, calculate the future value
        if ($error_message == '') {
            $future_value = $investment;
            for ($i = 1; $i <= $years; $i++) {
                $future_value += $future_value * $interest_rate * 0.01;
            }

            // Apply currency and percent formatting
            $investment_f = '$'.number_format($investment, 2);
            $yearly_rate_f = $interest_rate.'%';
            $future_value_f = '$'.number_format($future_value, 2);

            // Clear input fields
            $investment = '';
            $interest_rate = '';
            $years = '';
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Future Value Calculator</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <main>
        <h1>Future Value Calculator</h1>

        <!-- Display any error messages here -->
        <?php if (!empty($error_message)) { ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php } ?>

        <!-- The form submits to the same PHP file -->
        <form action="index.php" method="post">
            <div id="data">
                <label>Investment Amount:</label>
                <input type="text" name="investment" value="<?php echo htmlspecialchars($investment); ?>"><br>

                <label>Yearly Interest Rate:</label>
                <input type="text" name="interest_rate" value="<?php echo htmlspecialchars($interest_rate); ?>"><br>

                <label>Number of Years:</label>
                <input type="text" name="years" value="<?php echo htmlspecialchars($years); ?>"><br>
            </div>

            <div id="buttons">
                <label>&nbsp;</label>
                <input type="submit" value="Calculate"><br>
            </div>
        </form>

        <!-- Display results here if available -->
        <?php if ($future_value_f !== '') { ?>
            <h2>Results:</h2>
            <label>Investment Amount:</label>
            <span><?php echo htmlspecialchars($investment_f); ?></span><br />

            <label>Yearly Interest Rate:</label>
            <span><?php echo htmlspecialchars($yearly_rate_f); ?></span><br />

            <label>Number of Years:</label>
            <span><?php echo htmlspecialchars($years); ?></span><br />

            <label>Future Value:</label>
            <span><?php echo htmlspecialchars($future_value_f); ?></span><br />

            <p>This calculation was done on <?php echo date('m/d/Y'); ?>.</p>
        <?php } ?>
    </main>
</body>
</html>
