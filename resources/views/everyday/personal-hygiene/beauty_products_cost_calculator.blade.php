<x-calc.page
    title="Beauty Products Cost Calculator - SolveKit"
    description="Free beauty products cost calculator: what your skincare, makeup and hair products cost a year from their price and how long each lasts."
    lede="Add up what your beauty routine costs a year."
    about="Each product costs price × 52 ÷ weeks it lasts per year. Listing them shows which products cost the most over a year, not just at the till."
    :calc="['engine' => 'ev-care', 'tool' => 'beauty', 'fields' => ['products']]"
    :how-to="[
        ['name' => 'List your products', 'text' => 'Price and how many weeks each lasts.'],
    ]"
    :faqs="[
        ['question' => 'How much do people spend on beauty products?', 'answer' => 'It varies widely; list yours for a real figure.'],
        ['question' => 'How do I find how long a product lasts?', 'answer' => 'Note the date you open it and when it runs out.'],
        ['question' => 'Which costs most?', 'answer' => 'The list is sorted from most to least per year.'],
    ]"
>
    <x-calc.rows-editor name="products" label="Products" :columns="['name' => 'Product', 'price' => 'Price $', 'weeks' => 'Lasts (weeks)']" :rows="[['Moisturizer', 28, 8], ['Shampoo', 12, 6], ['Foundation', 38, 12], ['Sunscreen', 18, 6], ['Mascara', 25, 12]]" add-label="Add product" :text="['name']" />

    <x-calc.result label="Cost a year" />

    <x-calc.options :decimals="false" :examples="[
        'Daily routine' => ['products' => 'Moisturizer	28	8
Shampoo	12	6
Foundation	38	12
Sunscreen	18	6
Mascara	25	12'],
        'Minimal' => ['products' => 'Soap	4	4
Shampoo	8	8
Deodorant	6	8'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'month' => ['label' => 'Per month'],
            'day' => ['label' => 'Per day'],
            'ten' => ['label' => 'Over 10 years'],
        ]" />
        <x-calc.quick-ref heading="Each product" name="items" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>per year = price × 52.18 ÷ weeks it lasts</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
