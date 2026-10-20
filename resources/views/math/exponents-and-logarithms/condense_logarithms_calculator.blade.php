<x-calc.page
    title="Condense Logarithms Calculator - SolveKit"
    description="Free condense logarithms calculator: combine a sum of logs such as 2log x + log y − 3log z into a single logarithm."
    lede="Condense logarithms."
    about="Condensing runs the log rules backwards: move each coefficient up as a power, then turn sums into products and differences into quotients. 2 log x + log y − 3 log z = log(x²y/z³). All logs must share the same base."
    :calc="['engine' => 'mt-explog', 'tool' => 'expand_log', 'fields' => ['expr', 'base'], 'mode' => 'condense']"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Fractions such as 3/4 and negative numbers are fine; answers stay exact where possible.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'Condense 2 log x + log y − 3 log z.', 'answer' => 'log(x²y/z³).'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="expr" label="Sum of logarithms" value="2log(x) + log(y) - 3log(z)" type="text" inputmode="text" />
        <x-calc.field name="base" label="Base" value="10" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="Single logarithm" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['expr' => '2log(x) + log(y) - 3log(z)', 'base' => '10'],
        'Fractions' => ['expr' => '1/2 ln(a) - ln(b)', 'base' => 'e'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'terms' => ['label' => 'Terms'],
            'rules' => ['label' => 'Rules used'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>n log a = log aⁿ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
