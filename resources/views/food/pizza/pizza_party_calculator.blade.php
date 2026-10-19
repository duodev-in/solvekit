<x-calc.page
    title="Pizza Party Calculator - SolveKit"
    description="Free pizza party calculator: how many pizzas to order for adults and children, quickly or with a few questions about appetite, with the cost in your currency."
    lede="Work out how many pizzas to order."
    about="The catering rule is about 3 slices per adult and 2 per child, with 8 slices in a 12–14 in pizza and 12 in an 18 in. The guided mode adjusts for appetite, a meal or a snack, and other food on the table. Add a margin if you would rather have leftovers than run short."
    :calc="['engine' => 'fd-bake', 'tool' => 'pizza_party', 'fields' => ['mode', 'adults', 'kids', 'adult_slices', 'kid_slices', 'appetite', 'meal', 'sides', 'size', 'price', 'extra']]"
    :how-to="[
        ['name' => 'Enter the guests', 'text' => ''],
        ['name' => 'Choose quick numbers or answer the questions', 'text' => ''],
        ['name' => 'Pick the size and price', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How many 14 in pizzas for 10 adults and 6 children?', 'answer' => '6 pizzas.'],
        ['question' => 'And if pizza is just a snack?', 'answer' => '3 pizzas.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Plan" :options="['quick' => 'Quick', 'guided' => 'Guided questions']" selected="quick" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="adults" label="Adults" value="10" min="0" step="1" />
        <x-calc.field name="kids" label="Children" value="6" min="0" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="mode:quick">
            <x-calc.field name="adult_slices" label="Slices per adult" value="3" min="0" step="any" />
        </div>
        <div data-show-when="mode:quick">
            <x-calc.field name="kid_slices" label="Slices per child" value="2" min="0" step="any" />
        </div>
    </div>

    <div data-show-when="mode:guided" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.select name="appetite" label="Appetite" :options="['light' => 'Light eaters', 'normal' => 'Average', 'hungry' => 'Hungry (teens, sports)']" selected="normal" />
            <x-calc.select name="meal" label="Is pizza the meal?" :options="['meal' => 'Main meal', 'snack' => 'A snack']" selected="meal" />
            <x-calc.checkbox name="sides" label="Salads or other food served" :checked="false" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.select name="size" label="Pizza size" :options="['10' => '10 in (6 slices)', '12' => '12 in (8 slices)', '14' => '14 in (8 slices)', '16' => '16 in (10 slices)', '18' => '18 in (12 slices)']" selected="14" />
        <x-calc.field name="price" label="Price per pizza" value="15" min="0" step="0.01" suffix="$" />
        <x-calc.field name="extra" label="Extra margin" value="10" min="0" step="any" suffix="%" />
    </div>

    <x-calc.result label="Pizzas to order" />

    <x-calc.options :decimals="false" :examples="[
        'Party' => ['mode' => 'quick', 'adults' => 10, 'kids' => 6, 'adult_slices' => 3, 'kid_slices' => 2, 'appetite' => 'normal', 'meal' => 'meal', 'sides' => false, 'size' => '14', 'price' => 15, 'extra' => 10],
        'Snack' => ['mode' => 'guided', 'adults' => 10, 'kids' => 6, 'adult_slices' => 3, 'kid_slices' => 2, 'appetite' => 'normal', 'meal' => 'snack', 'sides' => true, 'size' => '14', 'price' => 15, 'extra' => 10],
        'Teen team' => ['mode' => 'guided', 'adults' => 2, 'kids' => 14, 'adult_slices' => 3, 'kid_slices' => 2, 'appetite' => 'hungry', 'meal' => 'meal', 'sides' => false, 'size' => '16', 'price' => 18, 'extra' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'slices' => ['label' => 'Slices per person'],
            'total' => ['label' => 'Slices ordered'],
            'cost' => ['label' => 'Cost'],
            'tip' => ['label' => 'Tip'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>slices = adults × 3 + children × 2</li>
            <li>pizzas = slices × (1 + margin) ÷ slices per pizza</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
