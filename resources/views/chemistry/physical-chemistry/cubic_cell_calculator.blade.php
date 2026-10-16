<x-calc.page
    title="Cubic Cell Calculator - SolveKit"
    description="Free cubic unit cell calculator: density, edge length, atomic radius, atoms per cell and packing fraction for simple, BCC, FCC and diamond cubic lattices."
    lede="Work out the density and geometry of a cubic unit cell."
    about="In the hard-sphere model atoms touch along the cell edge (simple cubic), body diagonal (BCC) or face diagonal (FCC). Density = atoms per cell × molar mass ÷ (Avogadro × a³). Enter the edge length from X-ray data for an exact density, or an atomic radius to estimate the edge."
    :calc="['engine' => 'chem-physical', 'tool' => 'cubic_cell', 'fields' => ['lattice', 'element', 'mode', 'edge', 'radius'], 'data' => ['elements' => app(\App\Services\ChemistryData::class)->elements(['name', 'weight'])]]"
    :how-to="[
        ['name' => 'Pick the lattice and element', 'text' => 'The element sets the molar mass.'],
        ['name' => 'Enter the edge length', 'text' => 'Or an atomic radius.'],
    ]"
    :faqs="[
        ['question' => 'How many atoms are in an FCC cell?', 'answer' => 'Four: 8 corners × ⅛ + 6 faces × ½.'],
        ['question' => 'Which packing is densest?', 'answer' => 'FCC and hexagonal close packing, at 74%.'],
        ['question' => 'Why compute density from the cell?', 'answer' => 'It checks a crystal structure against the measured density.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="lattice" label="Lattice" :options="['sc' => 'Simple cubic', 'bcc' => 'Body-centred cubic (BCC)', 'fcc' => 'Face-centred cubic (FCC)', 'diamond' => 'Diamond cubic']" selected="fcc" />
        <x-calc.select name="element" label="Element" :options="collect(config('elements'))->map(fn ($e) => $e['symbol'].' · '.$e['name'])->all()" selected="Cu" />
    </div>

    <x-calc.segmented name="mode" legend="From" :options="['edge' => 'Edge length a', 'radius' => 'Atomic radius']" selected="edge" />

    <div data-show-when="mode:edge">
        <x-calc.field name="edge" label="Edge length" value="3.6149e-10" min="0" suffix="m" help="Cu: 361.49 pm = 3.6149 × 10⁻¹⁰ m" />
    </div>

    <div data-show-when="mode:radius" hidden>
        <x-calc.field name="radius" label="Atomic radius" value="1.278e-10" min="0" suffix="m" />
    </div>

    <x-calc.result label="Density" />

    <x-calc.options :examples="[
        'Copper (FCC)' => ['lattice' => 'fcc', 'element' => 'Cu', 'mode' => 'edge', 'edge' => 3.6149e-10],
        'Iron (BCC)' => ['lattice' => 'bcc', 'element' => 'Fe', 'mode' => 'edge', 'edge' => 2.8665e-10],
        'Silicon (diamond)' => ['lattice' => 'diamond', 'element' => 'Si', 'mode' => 'edge', 'edge' => 5.431e-10],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'edge' => ['label' => 'Edge length'],
            'radius' => ['label' => 'Atomic radius'],
            'coordination' => ['label' => 'Coordination number'],
            'packing' => ['label' => 'Packing fraction'],
            'volume' => ['label' => 'Cell volume'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ρ = n M ÷ (Nₐ a³)</li>
            <li>SC a = 2r; BCC a = 4r/√3; FCC a = 2√2 r</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
