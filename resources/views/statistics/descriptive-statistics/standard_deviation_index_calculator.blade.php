<x-calc.page
    title="Standard Deviation Index Calculator - SolveKit"
    description="Free standard deviation index calculator: SDI for laboratory proficiency testing and quality control."
    lede="Find the SDI."
    about="The standard deviation index shows how far a laboratory’s result is from its peer group, in group standard deviations."
    :calc="['engine' => 'st-desc', 'tool' => 'sdi', 'fields' => ['lab', 'group', 'sd'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the SDI in the example?', 'answer' => '1.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="lab" label="Your laboratory’s mean" value="102.5" step="any" />
        <x-calc.field name="group" label="Peer group mean" value="100" step="any" />
        <x-calc.field name="sd" label="Peer group standard deviation" value="2.5" min="0" step="any" />
    </div>

    <x-calc.result label="Standard deviation index (SDI)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['lab' => 102.5, 'group' => 100, 'sd' => 2.5],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'bias' => ['label' => 'Difference from the group'],
            'verdict' => ['label' => 'Assessment'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
