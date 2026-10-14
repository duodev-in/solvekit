<x-calc.page
    title="Inches to Fraction Calculator - SolveKit"
    description="Professional inches to fraction calculator to convert decimal inches to fractions, millimeters, and centimeters. Perfect for woodworking and construction measurements."
    lede="Turn decimal inches into the nearest tape-measure fraction."
    about="The decimal is rounded to the nearest 1/2, 1/4, 1/8, 1/16, 1/32 or 1/64 of an inch, the marks on a tape measure, and the fraction is reduced. The difference from your exact value is shown so you know how far off the mark is."
    :calc="['engine' => 'inches-to-fraction']"
    :how-to="[
        ['name' => 'Enter decimal inches', 'text' => 'For example 2.6875.'],
        ['name' => 'Choose the precision', 'text' => 'Pick the smallest mark you can read, usually 1/16″.'],
        ['name' => 'Read the fraction', 'text' => 'The right panel shows the fraction at every precision.'],
    ]"
    :faqs="[
        ['question' => 'What is 0.625 inches as a fraction?', 'answer' => '0.625″ is exactly 5/8″.'],
        ['question' => 'Why only halves, quarters, eighths and sixteenths?', 'answer' => 'Those are the marks on imperial rulers and tape measures. A fraction like 1/3″ cannot be measured with one.'],
        ['question' => 'Which precision should I use?', 'answer' => '1/16″ suits most woodworking and construction. Machinists often use 1/32″ or 1/64″.'],
    ]"
>
    <x-calc.field name="value" label="Decimal inches" value="2.6875" suffix="in" placeholder="e.g. 2.6875" />

    <x-calc.segmented name="precision" legend="Round to the nearest" :options="['2' => '1/2', '4' => '1/4', '8' => '1/8', '16' => '1/16', '32' => '1/32', '64' => '1/64']" selected="16" />

    <x-calc.result label="Fraction" />

    <x-calc.options :decimals="false" :examples="[
        '0.375″' => ['value' => 0.375],
        '1.3″' => ['value' => 1.3],
        '3.14159″' => ['value' => 3.14159],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="At every precision" :grow="true" :rows="[
            'd2' => ['label' => 'Nearest 1/2″'],
            'd4' => ['label' => 'Nearest 1/4″'],
            'd8' => ['label' => 'Nearest 1/8″'],
            'd16' => ['label' => 'Nearest 1/16″'],
            'd32' => ['label' => 'Nearest 1/32″'],
            'd64' => ['label' => 'Nearest 1/64″'],
            'mm' => ['label' => 'Millimeters', 'unit' => 'mm'],
            'cm' => ['label' => 'Centimeters', 'unit' => 'cm'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>steps = round(inches × denominator)</li>
            <li>fraction = steps ÷ denominator, reduced</li>
            <li>error = fraction − inches</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
