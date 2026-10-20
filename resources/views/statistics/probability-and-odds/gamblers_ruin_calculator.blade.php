<x-calc.page
    title="Gambler's Ruin Calculator - SolveKit"
    description="Free gambler's ruin calculator: the chance of reaching a target before going broke, and the expected number of bets."
    lede="Solve the gambler's ruin."
    about="Betting one unit at a time with a slight disadvantage, the chance of doubling your money falls quickly as the target grows."
    :calc="['engine' => 'st-prob', 'tool' => 'gamblers_ruin', 'fields' => ['start', 'target', 'p'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the chance of turning 10 into 20 at 47.4% per bet?', 'answer' => '0.260969.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="start" label="Starting money (units)" value="10" min="1" step="any" />
        <x-calc.field name="target" label="Target (units)" value="20" min="1" step="any" />
        <x-calc.field name="p" label="Chance of winning each 1-unit bet (%)" value="47.4" min="0" step="any" />
    </div>

    <x-calc.result label="P(reach the target before going broke)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['start' => 10, 'target' => 20, 'p' => 47.4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'ruin' => ['label' => 'P(going broke)'],
            'rounds' => ['label' => 'Expected number of bets'],
            'fair' => ['label' => 'In a fair game'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
