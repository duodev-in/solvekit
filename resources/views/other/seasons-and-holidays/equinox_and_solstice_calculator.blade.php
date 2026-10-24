<x-calc.page
    title="Equinox and Solstice Calculator - SolveKit"
    description="Free equinox and solstice calculator: exact dates and times of the equinoxes and solstices for any year."
    lede="Find the equinoxes and solstices."
    about="The equinoxes and solstices mark the start of the astronomical seasons."
    :calc="['engine' => 'ot-misc', 'tool' => 'seasons', 'fields' => ['year', 'tz'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'When is the March equinox in 2027?', 'answer' => '20 March 2027, 20:25 UTC.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="year" label="Year" value="2027" min="1941" step="any" />
        <x-calc.field name="tz" label="Show times at UTC offset (hours)" value="0" step="any" />
    </div>

    <x-calc.result label="March equinox" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['year' => 2027, 'tz' => 0],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'june' => ['label' => 'June solstice'],
            'september' => ['label' => 'September equinox'],
            'december' => ['label' => 'December solstice'],
            'lengths' => ['label' => 'Season lengths (spring, summer, autumn, winter, northern)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
