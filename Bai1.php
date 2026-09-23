<?php
function generateFibonacci($n) {
    if ($n <= 0) {
        return [];
    }
    if ($n == 1) {
        return [0];
    }

    $fib = [0, 1];
    for ($i = 2; $i < $n; $i++) {
        $fib[] = $fib[$i - 1] + $fib[$i - 2];
    }

    return $fib;
}

$result = generateFibonacci(10);
echo "Dãy số Fibonacci đầu tiên có 10 phần tử: " . implode(", ", $result);
?>

