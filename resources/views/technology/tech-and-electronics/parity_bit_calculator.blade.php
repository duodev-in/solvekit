<x-calc.page
    title="Parity Bit Calculator - SolveKit"
    description="Free parity bit calculator: even or odd parity bit for binary data."
    lede="Find the parity bit."
    about="A parity bit makes the number of 1s even (or odd) so that a single flipped bit can be detected. Also known as Even Parity Bit Calculator, Odd Parity Bit Calculator and Parity Calculator."
    :calc="['engine' => 'tc-text', 'tool' => 'parity', 'fields' => ['data', 'type'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What even parity bit does 1011001 need?', 'answer' => '0.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="data" label="Data bits" value="1011001" type="text" inputmode="text" />
        <x-calc.select name="type" label="Parity" :options="['even' => 'Even', 'odd' => 'Odd']" selected="even" />
    </div>

    <x-calc.result label="Parity bit" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['data' => '1011001', 'type' => 'even'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'ones' => ['label' => 'Number of 1s'],
            'word' => ['label' => 'Data with parity bit'],
            'other' => ['label' => 'The other parity'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
