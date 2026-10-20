<x-calc.page
    title="Pie Chart Calculator - SolveKit"
    description="Free pie chart maker: percentages and angles for each category, drawn as a pie chart."
    lede="Make a pie chart."
    about="Each slice’s angle is its share of the total times 360°. Also known as Pie Chart Angle Calculator and Pie Chart Percentage Calculator."
    :calc="['engine' => 'st-dist', 'tool' => 'pie_chart', 'fields' => ['data'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What share is rent in the example?', 'answer' => 'Rent: 46.15%.'],
    ]"
>
    <x-calc.textarea name="data" label="Categories: label, value (one per line)" value="Rent, 1200
Food, 450
Transport, 220
Savings, 400
Other, 330" rows="5" />

    <x-calc.result label="Total" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => 'Rent, 1200
Food, 450
Transport, 220
Savings, 400
Other, 330'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Pie chart" name="pie" />
        <x-calc.rows heading="Details" :rows="[
            'largest' => ['label' => 'Largest slice'],
            'count' => ['label' => 'Slices'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Percentages and angles" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
