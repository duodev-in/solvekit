<x-calc.page
    title="Attendance Percentage Calculator - SolveKit"
    description="Free attendance percentage calculator: your attendance, classes needed to reach 75% and classes you can miss."
    lede="Track class attendance."
    about="Many colleges require 75% attendance; the calculator shows how far you are from it."
    :calc="['engine' => 'ot-edu', 'tool' => 'attendance', 'fields' => ['held', 'attended', 'required'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How many classes to reach 75% from 56 of 80?', 'answer' => '16.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="held" label="Classes held" value="80" min="1" step="any" />
        <x-calc.field name="attended" label="Classes attended" value="56" min="0" step="any" />
        <x-calc.field name="required" label="Required attendance (%)" value="75" min="0" step="any" />
    </div>

    <x-calc.result label="Attendance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['held' => 80, 'attended' => 56, 'required' => 75],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'need' => ['label' => 'Classes to attend in a row to reach the requirement'],
            'bunk' => ['label' => 'Classes you can miss and stay above it'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
