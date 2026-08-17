<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Realistic product names instead of Faker's Latin lorem-ipsum words --
     * matters for screenshots/demos, since gibberish names look broken.
     */
    protected array $productNames = [
        'Wireless Mouse', 'Mechanical Keyboard', 'USB-C Hub', 'Office Chair',
        'Standing Desk', 'Monitor Stand', 'Webcam 1080p', 'Desk Lamp',
        'Laptop Sleeve', 'Bluetooth Speaker', 'Noise Cancelling Headphones',
        'Portable SSD 1TB', 'HDMI Cable 2m', 'Phone Stand', 'Wireless Charger',
        'Ergonomic Footrest', 'Cable Organizer', 'Laptop Cooling Pad',
        'External Hard Drive 2TB', 'Ring Light', 'Microphone Arm',
        'Desk Mat', 'Power Strip', 'Wireless Keyboard', 'Graphics Tablet',
        'Document Scanner', 'Label Printer', 'Whiteboard 90x60cm',
        'Filing Cabinet', 'Bookshelf Speaker', 'Router AC1200', 'Network Switch',
        'Surge Protector', 'Ethernet Cable 5m', 'Laptop Backpack',
        'Wireless Earbuds', 'Smart Plug', 'Desk Organizer Tray', 'Paper Shredder',
        'Barcode Scanner',
    ];

    public function definition(): array
    {
        $name = fake()->randomElement($this->productNames);

        return [
            'name' => $name,
            'sku' => strtoupper(str_replace(' ', '-', $name)) . '-' . fake()->unique()->numberBetween(100, 999),
            'price' => fake()->randomFloat(2, 5, 500),
            'stock' => fake()->numberBetween(0, 1000),
            'status' => fake()->randomElement(['active', 'inactive']),
        ];
    }
}