<x-calc.page
    title="Age on Other Planets Calculator - SolveKit"
    description="Free age on other planets calculator: your age in Mercury, Venus, Mars, Jupiter and other planetary years."
    lede="Find your age on other planets."
    about="A year on each planet is one trip around the Sun, so your age differs on every planet."
    :calc="['engine' => 'ot-misc', 'tool' => 'age_planets', 'fields' => ['birth', 'on'], 'data' => ['units' => collect(config('units'))->only([])->all(), 'physics' => collect(config('physics_data'))->only(['bodies'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How old is the example person on Mars?', 'answer' => '16.667 years.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="birth" label="Date of birth" value="1995-06-15" type="date" />
        <x-calc.field name="on" label="On date (blank = today)" value="" type="date" />
    </div>

    <x-calc.result label="Age on Mars" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['birth' => '1995-06-15', 'on' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'mercury' => ['label' => 'Mercury'],
            'venus' => ['label' => 'Venus'],
            'earth' => ['label' => 'Earth'],
            'jupiter' => ['label' => 'Jupiter'],
            'saturn' => ['label' => 'Saturn'],
            'uranus' => ['label' => 'Uranus'],
            'neptune' => ['label' => 'Neptune'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
