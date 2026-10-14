<x-calc.page
    title="Pixels to Inches Converter - SolveKit"
    description="Professional pixels to inches converter for digital design and printing. Convert pixels to inches using DPI/PPI settings for accurate print sizing."
    lede="Find the printed size of an image from its pixel count and resolution."
    about="Printed size in inches is the pixel count divided by the resolution in dots (or pixels) per inch. The same image prints larger at a lower DPI and smaller at a higher one."
    :calc="['engine' => 'pixels-to-inches']"
    :how-to="[
        ['name' => 'Enter the pixel count', 'text' => 'Use the width or height of the image in pixels.'],
        ['name' => 'Enter the resolution', 'text' => '300 DPI is standard for photo printing; 72 or 96 for screens.'],
    ]"
    :faqs="[
        ['question' => 'How many inches is 3000 pixels at 300 DPI?', 'answer' => '3000 ÷ 300 = 10 inches.'],
        ['question' => 'What DPI should I print at?', 'answer' => '300 DPI is standard for photos and print. Large posters viewed from a distance can use 150 DPI.'],
        ['question' => 'Is DPI the same as PPI?', 'answer' => 'For converting pixels to print size they are used interchangeably: both mean pixels per inch of output.'],
    ]"
>
    <div class="grid grid-cols-2 gap-3">
        <x-calc.field name="pixels" label="Pixels" value="3000" min="0" suffix="px" placeholder="Pixels" />
        <x-calc.field name="dpi" label="Resolution" value="300" min="1" suffix="DPI" placeholder="DPI" />
    </div>

    <x-calc.result label="Inches" />

    <x-calc.options :examples="[
        '72 DPI' => ['dpi' => 72],
        '150 DPI' => ['dpi' => 150],
        '300 DPI' => ['dpi' => 300],
        '600 DPI' => ['dpi' => 600],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Printed size" :rows="[
            'cm' => ['label' => 'Centimeters', 'unit' => 'cm'],
            'mm' => ['label' => 'Millimeters', 'unit' => 'mm'],
        ]" />
        <x-calc.rows heading="Same pixels at other resolutions" hint="Inches" :rows="[
            'dpi72' => ['label' => '72 DPI', 'unit' => 'in'],
            'dpi96' => ['label' => '96 DPI', 'unit' => 'in'],
            'dpi150' => ['label' => '150 DPI', 'unit' => 'in'],
            'dpi300' => ['label' => '300 DPI', 'unit' => 'in'],
            'dpi600' => ['label' => '600 DPI', 'unit' => 'in'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>inches = pixels ÷ DPI</li>
            <li>centimeters = inches × 2.54</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
