<x-calc.page
    title="Kurtosis Calculator - SolveKit"
    description="Free kurtosis calculator: excess kurtosis G₂, population g₂ and the tail shape of your data."
    lede="Measure kurtosis."
    about="Kurtosis measures how heavy the tails of a distribution are compared with a normal distribution."
    :calc="['engine' => 'st-desc', 'tool' => 'kurtosis', 'fields' => ['data'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the excess kurtosis of the example?', 'answer' => '6.06105.'],
    ]"
>
    <x-calc.textarea name="data" label="Data (separate with commas, spaces or new lines)" value="2, 4, 4, 5, 5, 5, 5, 6, 6, 8, 15" rows="3" />

    <x-calc.result label="Excess kurtosis G₂" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '2, 4, 4, 5, 5, 5, 5, 6, 6, 8, 15'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'g2' => ['label' => 'Population excess kurtosis g₂'],
            'b2' => ['label' => 'b₂ (Minitab)'],
            'raw' => ['label' => 'Kurtosis (not excess) g₂ + 3'],
            'se' => ['label' => 'Standard error'],
            'shape' => ['label' => 'Shape'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
