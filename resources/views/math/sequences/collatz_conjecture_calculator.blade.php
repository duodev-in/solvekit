<x-calc.page
    title="Collatz Conjecture Calculator - SolveKit"
    description="Free Collatz conjecture calculator: the 3n + 1 sequence from any start number, its stopping time and peak, with a graph."
    lede="Run the Collatz sequence."
    about="Take any positive whole number: halve it if even, otherwise multiply by 3 and add 1. The Collatz conjecture says you always reach 1. It has been checked for every start below 2⁶⁸ but never proved. 27 takes 111 steps and peaks at 9,232."
    :calc="['engine' => 'mt-seq', 'tool' => 'collatz', 'fields' => ['n']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Fractions such as 3/4 and negative numbers are fine; answers stay exact where possible.'],
        ['name' => 'Read the answer and the working', 'text' => ''],
    ]"
    :faqs="[
        ['question' => 'How many steps does 27 take?', 'answer' => '111 steps.'],
    ]"
>
    <x-calc.field name="n" label="Start number" value="27" type="text" inputmode="decimal" />

    <x-calc.result label="Steps to reach 1" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['n' => '27'],
        'Small' => ['n' => '6'],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Trajectory" name="graph" />
        <x-calc.rows heading="Details" :rows="[
            'peak' => ['label' => 'Highest value'],
            'sequence' => ['label' => 'Sequence'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>n → n/2 or 3n + 1</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
