<x-calc.page
    title="Power Mod Calculator - SolveKit"
    description="Free power mod calculator: aᵇ mod m for huge exponents by square-and-multiply."
    lede="Calculate a power modulo m."
    about="Modular exponentiation keeps numbers small by reducing after every multiplication. Square-and-multiply needs only about log₂(b) steps, so 7^560 mod 561 is quick even though 7^560 has 473 digits."
    :calc="['engine' => 'mt-number', 'tool' => 'power_mod', 'fields' => ['a', 'b', 'm']]"
    :how-to="[
        ['name' => 'Enter the numbers', 'text' => 'Whole numbers can be as long as you like; decimals and fractions stay exact.'],
        ['name' => 'Read the answer', 'text' => 'The working shows each step.'],
    ]"
    :faqs="[
        ['question' => 'What is 7^560 mod 561?', 'answer' => '1.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="a" label="Base" value="7" type="text" inputmode="decimal" />
        <x-calc.field name="b" label="Exponent" value="560" type="text" inputmode="decimal" />
        <x-calc.field name="m" label="Modulus" value="561" type="text" inputmode="decimal" />
    </div>

    <x-calc.result label="aᵇ mod m" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['a' => '7', 'b' => '560', 'm' => '561'],
        'Small' => ['a' => '3', 'b' => '13', 'm' => '7'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'binary' => ['label' => 'Exponent in binary'],
            'check' => ['label' => 'Check'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>square-and-multiply</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
