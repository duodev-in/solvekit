<x-calc.page
    title="Numbers to Letters Converter - SolveKit"
    description="Free numbers to letters converter: 1 = A … 26 = Z, 0 = A or ASCII codes to letters."
    lede="Convert numbers to letters."
    about="Each number becomes the letter at that position of the alphabet."
    :calc="['engine' => 'tc-text', 'tool' => 'numbers_letters', 'fields' => ['nums', 'scheme', 'caseOut'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is 8 5 12 12 15?', 'answer' => 'It spells HELLO WORLD.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.textarea name="nums" label="Numbers (words separated by /)" value="8 5 12 12 15 / 23 15 18 12 4" rows="3" />
        <x-calc.select name="scheme" label="Scheme" :options="['a1' => '1 = A … 26 = Z', 'a0' => '0 = A … 25 = Z', 'ascii' => 'ASCII codes']" selected="a1" />
        <x-calc.select name="caseOut" label="Letters" :options="['upper' => 'UPPERCASE', 'lower' => 'lowercase']" selected="upper" />
    </div>

    <x-calc.result label="Letters" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['nums' => '8 5 12 12 15 / 23 15 18 12 4', 'scheme' => 'a1', 'caseOut' => 'upper'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'count' => ['label' => 'Letters'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
