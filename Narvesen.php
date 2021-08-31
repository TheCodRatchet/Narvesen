<?php

function createProduct(string $name, int $price, int $amount): stdClass
{
    $product = new stdClass();
    $product->name = $name;
    $product->price = $price;
    $product->amount = $amount;

    return $product;
}

$products = [
    createProduct("Milkshake", 155, 15),
    createProduct("Beer", 85, 30),
    createProduct("Magazine", 100, 50),
    createProduct("Chips", 130, 25),
    createProduct("Pen", 5, 100),
    createProduct("Chocolate", 45, 40),
    createProduct("Sandwich", 250, 13),
    createProduct("Water", 15, 24),
    createProduct("Iphone case", 450, 3),
    createProduct("Iphone", 70000, 1),
];

$person = new stdClass();
$person->cash = (float)readline("Enter cash amount($0.00): ") * 100;
$person->bag = [];
while ($person->cash <= 0) {
    echo 'Please enter valid cash amount' . PHP_EOL;
    $person->cash = (float)readline("Enter cash amount($0.00): ") * 100;
}

foreach ($products as $key => $product) {
    echo "$key - {$product->name}: " . $product->price / 100 . " (In stock: $product->amount)" . PHP_EOL;
}
$total = 0;
$shopping = true;

while($shopping){
    $chooseProduct = (readline("Please choose item from catalog (id): "));
    while (isset($products[$chooseProduct]) == false && is_numeric($chooseProduct)) {
        echo "Product not Found." . PHP_EOL;
        $chooseProduct = (readline("Please choose item from catalog (id): "));
    }

    $chooseAmount = (int)readline("Please choose amount of this item: ");
    while ($chooseAmount > $products[$chooseProduct]->amount || $chooseAmount <= 0) {
        echo "Selected too much/ selected nothing." . PHP_EOL;
        $chooseAmount = (int)readline("Please choose amount of this item: ");
    }

    $selectedProduct = clone $products[$chooseProduct];
    $selectedProduct->amount = $chooseAmount;
    $person->bag[] = $selectedProduct;
    $products[$chooseProduct]->amount -= $chooseAmount;

    $continueShopping = strtolower(readline("Do you want to continue shopping? [y,n]"));
    while ($continueShopping !== "y" && $continueShopping !== "n"){
        echo "Invalid input!!!" . PHP_EOL;
        $continueShopping = strtolower(readline("Do you want to continue shopping? [y,n]"));
    }

    if ($continueShopping == "n"){
        $shopping = false;
    }
}

foreach ($person->bag as $product) {
    $total += $product->price * $product->amount;
}

echo $total / 100 . "$" . PHP_EOL;

if ($person->cash >= $total){
    echo "Your change is: " . ($person->cash - $total) / 100 . "$" . PHP_EOL;
} else {
    echo "You don't have enough money" . PHP_EOL;
}