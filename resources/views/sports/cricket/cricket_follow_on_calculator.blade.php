<x-calc.page
    title="Cricket Follow-On Calculator - SolveKit"
    description="Free follow-on calculator: whether the follow-on can be enforced under MCC Law 14."
    lede="Check the follow-on."
    about="The side batting first may make the other side bat again if it leads by enough: 200 runs in a five-day match, 150 in three or four days, 100 in two days and 75 in one."
    :calc="['engine' => 'sp-ball', 'tool' => 'follow_on', 'fields' => ['days', 'first', 'second'], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()]]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'Can 450 against 230 be followed on in a Test?', 'answer' => 'Yes: the lead is 220 runs.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="days" label="Match length" :options="['1' => 'One day', '2' => 'Two days', '3' => 'Three or four days', '5' => 'Five days or more (Tests)']" selected="5" />
        <x-calc.field name="first" label="First-innings score of the team batting first" value="450" min="0" step="any" />
        <x-calc.field name="second" label="First-innings score of the other team" value="230" min="0" step="any" />
    </div>

    <x-calc.result label="Can the follow-on be enforced?" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['days' => '5', 'first' => 450, 'second' => 230],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'lead' => ['label' => 'First-innings lead'],
            'needed' => ['label' => 'Lead needed'],
            'avoid' => ['label' => 'Runs the second team needed to avoid it'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
