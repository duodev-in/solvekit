<x-calc.page
    title="Least to Greatest Calculator - SolveKit"
    description="Free least to greatest calculator: order numbers, decimals, fractions, mixed numbers and percentages, ascending or descending."
    lede="Put numbers in order."
    about="Every value is read exactly, so fractions and decimals compare correctly (3/4 > 0.7, 1 1/2 = 1.5). Also known as Ascending Order Calculator, Greatest To Least Calculator, Least to Greatest Decimals Calculator, Order from Least to Greatest Calculator, Ordering Decimals Calculator and Ordering Numbers Calculator."
    :calc="['engine' => 'st-desc', 'tool' => 'least_greatest', 'fields' => ['data', 'order', 'dupes'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do the example values order?', 'answer' => '-2, 12%, 0.45, 0.5, 2/3, 3/4, 1 1/2.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="data" label="Numbers (decimals, fractions like 3/4, mixed numbers like 1 1/2, percentages)" value="0.5, 3/4, -2, 1 1/2, 0.45, 12%, 2/3" rows="3" />
        <x-calc.select name="order" label="Order" :options="['asc' => 'Least to greatest (ascending)', 'desc' => 'Greatest to least (descending)']" selected="asc" />
        <x-calc.select name="dupes" label="Repeated values" :options="['keep' => 'Keep', 'drop' => 'Remove']" selected="keep" />
    </div>

    <x-calc.result label="Ordered list" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '0.5, 3/4, -2, 1 1/2, 0.45, 12%, 2/3', 'order' => 'asc', 'dupes' => 'keep'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'count' => ['label' => 'Values'],
            'smallest' => ['label' => 'Smallest'],
            'largest' => ['label' => 'Largest'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
