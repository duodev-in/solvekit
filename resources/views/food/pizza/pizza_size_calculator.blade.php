<x-calc.page
    title="Pizza Size Calculator - SolveKit"
    description="Free pizza size calculator: compare round and rectangular pizzas by area and price per square inch to find the best value, and how many small pizzas equal a large."
    lede="Compare pizza sizes and prices."
    about="A pizza's area grows with the square of its diameter: π × d² ÷ 4. An 18 in pizza has more than twice the area of a 12 in, so large pizzas are usually better value. Enter each option's size and price (add a width for rectangular pizzas) to compare price per area, or use the comparison mode to see how many small pizzas equal one large."
    :calc="['engine' => 'fd-bake', 'tool' => 'pizza_size', 'fields' => ['mode', 'pizzas', 'small', 'large', 'small_price']]"
    :how-to="[
        ['name' => 'Enter each pizza size and price', 'text' => ''],
        ['name' => 'Read the price per area', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Is a $22 18 in pizza better value than a $12 12 in?', 'answer' => '18 in is best: $8.65 per 100 in² ($1.34 per 100 cm²).'],
        ['question' => 'How many 10 in pizzas equal a 16 in?', 'answer' => '2.56 × 10 in (A 16 in pizza has 2.56 times the area of a 10 in pizza).'],
    ]"
>
    <x-calc.segmented name="mode" legend="Mode" :options="['value' => 'Best value', 'compare' => 'Compare two sizes']" selected="value" />

    <div data-show-when="mode:value">
        <x-calc.rows-editor name="pizzas" label="Pizzas (diameter or length, width for rectangles, price, count)" :columns="['size' => 'Size (in)', 'width' => 'Width (in)', 'price' => 'Price', 'count' => 'Count']" :rows="[['12', '-', '12', '1'], ['16', '-', '18', '1'], ['18', '-', '22', '1']]" add-label="Add pizza" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="mode:compare" hidden>
            <x-calc.field name="small" label="Small pizza" value="10" min="0" step="any" suffix="in" />
        </div>
        <div data-show-when="mode:compare" hidden>
            <x-calc.field name="large" label="Large pizza" value="16" min="0" step="any" suffix="in" />
        </div>
        <div data-show-when="mode:compare" hidden>
            <x-calc.field name="small_price" label="Small price (optional)" value="9" min="0" step="0.01" suffix="$" />
        </div>
    </div>

    <x-calc.result label="Best value" />

    <x-calc.options :decimals="false" :examples="[
        'Menu' => ['mode' => 'value', 'pizzas' => '12 - 12 1
16 - 18 1
18 - 22 1', 'small' => 10, 'large' => 16, 'small_price' => 9],
        'Two mediums or a large' => ['mode' => 'value', 'pizzas' => '14 - 16 2
18 - 22 1', 'small' => 10, 'large' => 16, 'small_price' => 9],
        'Compare' => ['mode' => 'compare', 'pizzas' => '12 - 12 1
16 - 18 1
18 - 22 1', 'small' => 10, 'large' => 16, 'small_price' => 9],
    ]" />

    <x-slot:panel>
        <div data-show-when="mode:value">
            <x-calc.rows heading="Details" :rows="[
                'best' => ['label' => 'Best option'],
                'worst' => ['label' => 'Worst value'],
                'area' => ['label' => 'Total area'],
            ]" />
        </div>
        <div data-show-when="mode:compare" hidden>
            <x-calc.rows heading="Details" :rows="[
                'small' => ['label' => 'Small area'],
                'large' => ['label' => 'Large area'],
                'fair' => ['label' => 'Fair price'],
            ]" />
        </div>
        <x-calc.grid heading="Price per area" name="pizzas" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>area = π d² ÷ 4 (round) or length × width</li>
            <li>value = price ÷ area</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
