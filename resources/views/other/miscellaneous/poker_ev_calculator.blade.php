<x-calc.page
    title="Poker EV Calculator - SolveKit"
    description="Free poker EV calculator: expected value of a call, pot odds and break-even equity."
    lede="Decide whether to call."
    about="A call is profitable when your chance to win beats the pot odds."
    :calc="['engine' => 'ot-play', 'tool' => 'poker_ev', 'fields' => ['pot', 'call', 'equity'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'Is calling 25 into 100 with 30% equity profitable?', 'answer' => 'Yes: EV +12.5.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="pot" label="Pot before your call (including the bet)" value="100" min="0" step="any" />
        <x-calc.field name="call" label="Amount to call" value="25" min="0" step="any" />
        <x-calc.field name="equity" label="Your chance to win (%)" value="30" min="0" step="any" />
    </div>

    <x-calc.result label="EV of calling" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['pot' => 100, 'call' => 25, 'equity' => 30],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'potOdds' => ['label' => 'Pot odds'],
            'breakEven' => ['label' => 'Break-even equity'],
            'verdict' => ['label' => 'Decision'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
