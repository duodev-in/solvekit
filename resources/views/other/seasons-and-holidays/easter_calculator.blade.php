<x-calc.page
    title="Easter Calculator - SolveKit"
    description="Free Easter date calculator: Western and Orthodox Easter for any year, with Ash Wednesday, Good Friday and Pentecost."
    lede="Find the date of Easter."
    about="Easter falls on the first Sunday after the ecclesiastical full moon on or after 21 March."
    :calc="['engine' => 'ot-misc', 'tool' => 'easter', 'fields' => ['year', 'church'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'When is Easter in 2027?', 'answer' => '28 March 2027.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="year" label="Year" value="2027" min="1583" step="any" />
        <x-calc.select name="church" label="Church" :options="['western' => 'Western (Catholic, Protestant)', 'orthodox' => 'Orthodox']" selected="western" />
    </div>

    <x-calc.result label="Easter Sunday" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['year' => 2027, 'church' => 'western'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'other' => ['label' => 'The other church’s Easter'],
            'ash' => ['label' => 'Ash Wednesday'],
            'goodFriday' => ['label' => 'Good Friday'],
            'pentecost' => ['label' => 'Pentecost'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="The next ten years" name="table" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
