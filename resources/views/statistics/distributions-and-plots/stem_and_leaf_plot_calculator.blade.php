<x-calc.page
    title="Stem and Leaf Plot Calculator - SolveKit"
    description="Free stem-and-leaf plot maker: stems and leaves with a key, automatic leaf unit and split stems."
    lede="Make a stem-and-leaf plot."
    about="A stem-and-leaf plot splits each value into a stem (leading digits) and a leaf (last digit), showing the shape while keeping every value."
    :calc="['engine' => 'st-dist', 'tool' => 'stem_leaf', 'fields' => ['data', 'leaf', 'split'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'How many stems does the example use?', 'answer' => '6.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="data" label="Data" value="12, 15, 21, 23, 23, 27, 31, 34, 36, 38, 41, 42, 45, 47, 52, 58, 63" rows="3" />
        <x-calc.select name="leaf" label="Leaf unit" :options="['1' => '1', '10' => '10', '100' => '100', 'auto' => 'Automatic', '0.1' => '0.1']" selected="auto" />
        <x-calc.select name="split" label="Stems" :options="['one' => 'One line per stem', 'two' => 'Split stems (0–4 and 5–9)']" selected="one" />
    </div>

    <x-calc.result label="Stems" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '12, 15, 21, 23, 23, 27, 31, 34, 36, 38, 41, 42, 45, 47, 52, 58, 63', 'leaf' => 'auto', 'split' => 'one'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'key' => ['label' => 'Key'],
            'n' => ['label' => 'Values'],
            'median' => ['label' => 'Median'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Stem-and-leaf plot" name="plot" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
