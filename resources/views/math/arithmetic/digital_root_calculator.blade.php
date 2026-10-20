<x-calc.page
    title="Digital Root Calculator - SolveKit"
    description="Free digital root calculator: add the digits repeatedly until one digit remains, with the link to n mod 9."
    lede="Find the digital root."
    about="The digital root repeats the digit sum until a single digit is left: 65,536 → 25 → 7. It equals n mod 9 (with 9 instead of 0), which is the basis of the old “casting out nines” check."
    :calc="['engine' => 'mt-arith', 'tool' => 'digit_sum', 'fields' => ['n'], 'root' => true]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is the digital root of 65,536?', 'answer' => '7.'],
    ]"
>
    <x-calc.field name="n" label="Number" value="65536" type="text" inputmode="decimal" />

    <x-calc.result label="Digital root" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['n' => '65536'],
        'Large' => ['n' => '123456789123456789'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'sum' => ['label' => 'Digit sum'],
            'root' => ['label' => 'Digital root'],
            'nine' => ['label' => 'Mod 9'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>dr(n) = 1 + (n − 1) mod 9</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
