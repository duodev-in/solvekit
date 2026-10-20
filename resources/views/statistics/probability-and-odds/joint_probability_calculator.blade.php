<x-calc.page
    title="Joint Probability Calculator - SolveKit"
    description="Free joint probability calculator: P(A and B) for independent, dependent or mutually exclusive events, with P(A or B)."
    lede="Find a joint probability."
    about="The joint probability of two events is the chance both happen. For independent events it is P(A) × P(B); otherwise P(A) × P(B|A)."
    :calc="['engine' => 'st-prob', 'tool' => 'joint', 'fields' => ['pA', 'pB', 'relation', 'pBA'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is P(A and B) for independent events with 0.5 and 0.4?', 'answer' => '0.2.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="pA" label="P(A)" value="0.5" min="0" step="any" />
        <x-calc.field name="pB" label="P(B)" value="0.4" min="0" step="any" />
        <x-calc.select name="relation" label="A and B are" :options="['independent' => 'Independent', 'given' => 'Dependent: I know P(B | A)', 'exclusive' => 'Mutually exclusive']" selected="independent" />
        <div data-show-when="relation:given">
            <x-calc.field name="pBA" label="P(B | A)" value="0.6" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="P(A and B)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['pA' => 0.5, 'pB' => 0.4, 'relation' => 'independent', 'pBA' => 0.6],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'or' => ['label' => 'P(A or B)'],
            'neither' => ['label' => 'P(neither)'],
            'aOnly' => ['label' => 'P(A but not B)'],
            'bOnly' => ['label' => 'P(B but not A)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
