<x-calc.page
    title="Drake Equation for Love Calculator - SolveKit"
    description="Free Drake equation for love calculator: estimate how many potential partners live near you by multiplying the share of people who match each of your criteria."
    lede="Estimate your number of potential partners, for fun."
    about="Frank Drake's equation estimates alien civilizations by multiplying a chain of fractions. Economist Peter Backus applied it to dating in 2010 (Why I Don't Have a Girlfriend). Here the population near you is multiplied by each share you choose. It is a playful estimate: the shares are your guesses."
    :calc="['engine' => 'ev-fun', 'tool' => 'drake_love', 'fields' => ['population', 'gender', 'age', 'single', 'education', 'attractive', 'mutual', 'compatible']]"
    :how-to="[
        ['name' => 'Enter your area\'s population', 'text' => 'City or region.'],
        ['name' => 'Set each share', 'text' => 'Your honest guesses.'],
    ]"
    :faqs="[
        ['question' => 'What is the Drake equation for love?', 'answer' => 'A chain of fractions multiplied together to estimate how many people match your criteria.'],
        ['question' => 'Who came up with it?', 'answer' => 'Peter Backus, in a 2010 paper about dating in London.'],
        ['question' => 'Is it accurate?', 'answer' => 'No: it is a fun way to see how criteria multiply.'],
    ]"
>
    <x-calc.field name="population" label="People in your area" value="2000000" min="1" step="1000" />

    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <x-calc.field name="gender" label="Of the gender you like" value="50" min="0" max="100" suffix="%" />
        <x-calc.field name="age" label="In your age range" value="15" min="0" max="100" suffix="%" />
        <x-calc.field name="single" label="Single" value="40" min="0" max="100" suffix="%" />
        <x-calc.field name="education" label="With the education you want" value="40" min="0" max="100" suffix="%" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="attractive" label="You find attractive" value="10" min="0" max="100" suffix="%" />
        <x-calc.field name="mutual" label="Who find you attractive" value="10" min="0" max="100" suffix="%" />
        <x-calc.field name="compatible" label="You get on with" value="20" min="0" max="100" suffix="%" />
    </div>

    <x-calc.result label="Potential partners" />

    <x-calc.options :decimals="false" :examples="[
        'City of 2 million' => ['population' => 2000000, 'gender' => 50, 'age' => 15, 'single' => 40, 'education' => 40, 'attractive' => 10, 'mutual' => 10, 'compatible' => 20],
        'Small town' => ['population' => 25000, 'gender' => 50, 'age' => 18, 'single' => 45, 'education' => 50, 'attractive' => 15, 'mutual' => 15, 'compatible' => 25],
        'Picky' => ['population' => 8000000, 'gender' => 50, 'age' => 10, 'single' => 35, 'education' => 25, 'attractive' => 5, 'mutual' => 5, 'compatible' => 10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'share' => ['label' => 'Odds'],
            'note' => ['label' => 'Note'],
        ]" />
        <x-calc.quick-ref heading="Step by step" name="steps" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>N = population × f1 × f2 × …</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
