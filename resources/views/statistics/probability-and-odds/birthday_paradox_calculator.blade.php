<x-calc.page
    title="Birthday Paradox Calculator - SolveKit"
    description="Free birthday paradox calculator: the probability that two people in a group share a birthday, and the group size for any probability."
    lede="Find the chance of a shared birthday."
    about="With only 23 people, a shared birthday is more likely than not. The number of pairs grows much faster than the group, which is why the answer surprises."
    :calc="['engine' => 'st-prob', 'tool' => 'birthday', 'fields' => ['want', 'n', 'target', 'days'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the chance for 23 people?', 'answer' => '0.507297.'],
        ['question' => 'How many people give a 99% chance?', 'answer' => '57 people.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="want" label="Find" :options="['prob' => 'The probability for a group', 'people' => 'People needed for a probability']" selected="prob" />
        <div data-show-when="want:prob">
            <x-calc.field name="n" label="People in the group" value="23" min="1" step="any" />
        </div>
        <div data-show-when="want:people">
            <x-calc.field name="target" label="Target probability (%)" value="50" min="0" step="any" />
        </div>
        <x-calc.field name="days" label="Days in the year" value="365" min="1" step="any" />
    </div>

    <x-calc.result label="P(at least two share a birthday)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['want' => 'prob', 'n' => 23, 'target' => 50, 'days' => 365],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Probability by group size" name="curve" />
        <x-calc.rows heading="Details" :rows="[
            'none' => ['label' => 'P(all birthdays different)'],
            'pairs' => ['label' => 'Pairs of people'],
            'half' => ['label' => 'People for 50%'],
            'ninetynine' => ['label' => 'People for 99%'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
