<x-tool-page-layout
    title="Cubic Meter Calculator - ConvertPro"
    description="Professional cubic meter calculator to calculate volume in m³ from length, width, and height dimensions. Perfect for metric volume calculations."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="space-y-2">
                            
                            <!-- Calculator Header -->
                            <div class="rounded-md bg-white p-2.5 shadow-sm">
                                <h1 class="text-sm font-semibold text-slate-900">Cubic Meter Calculator</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="rounded-md bg-white p-3 shadow-sm">
                                
                                <div class="grid gap-3 lg:grid-cols-9">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-3" id="calculatorForm">

                                                                            <!-- Dimension Inputs -->
                                                                            @foreach(['Length', 'Width', 'Height'] as $dimension)
                                                                            @php $lower = strtolower($dimension); @endphp
                                                                            <div class="space-y-2">
                                                                                <label for="{{ $lower }}" class="block text-sm font-semibold text-slate-700">
                                                                                    {{ $dimension }}
                                                                                </label>
                                                                                <div class="flex gap-3">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="{{ $lower }}" 
                                                                                        class="flex-1 px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                        placeholder="Enter {{ strtolower($dimension) }}"
                                                                                        step="any"
                                                                                        min="0"
                                                                                    >
                                                                                    <select 
                                                                                        id="{{ $lower }}Unit" 
                                                                                        class="w-24 px-3 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                    >
                                                                                        <option value="mm">mm</option>
                                                                                        <option value="cm">cm</option>
                                                                                        <option value="m" selected>m</option>
                                                                                        <option value="km">km</option>
                                                                                        <option value="in">in</option>
                                                                                        <option value="ft">ft</option>
                                                                                        <option value="yd">yd</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            @endforeach

                                                                            <!-- Output Unit Selection -->
                                                                            <div class="space-y-2">
                                                                                <label for="outputUnit" class="block text-sm font-semibold text-slate-700">
                                                                                    Output Unit
                                                                                </label>
                                                                                <select 
                                                                                    id="outputUnit" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                >
                                                                                    <option value="mm3">Cubic Millimeters (mm³)</option>
                                                                                    <option value="cm3">Cubic Centimeters (cm³)</option>
                                                                                    <option value="m3" selected>Cubic Meters (m³)</option>
                                                                                    <option value="km3">Cubic Kilometers (km³)</option>
                                                                                    <option value="ft3">Cubic Feet (ft³)</option>
                                                                                    <option value="in3">Cubic Inches (in³)</option>
                                                                                    <option value="yd3">Cubic Yards (yd³)</option>
                                                                                    <option value="l">Liters (L)</option>
                                                                                </select>
                                                                            </div>

                                                                            <div class="flex items-center justify-between gap-3 rounded-md border border-slate-200 bg-slate-50 px-2 py-1.5">
                                                                                <p class="text-[11px] text-slate-500">Shortcut: Ctrl + Shift + C to clear</p>
                                                                                <button
                                                                                    type="button"
                                                                                    id="clearButton"
                                                                                    class="rounded-md bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700"
                                                                                >
                                                                                    Clear
                                                                                </button>
                                                                            </div>

                                                                        </form>
                                    </div>
                                    <div class="space-y-4 lg:col-span-4">
                                        <!-- Results Display -->
                                                                        <div class="mt-8 space-y-4">
                                                                            <h3 class="text-lg font-semibold text-slate-900 text-center mb-4">Converted Values</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Volume Result</h4>
                                                                                        <p class="text-[11px] text-slate-500" id="result-description">Calculated volume</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="output">--</div>
                                                                                        <div class="text-xs text-slate-500 font-medium" id="unit-display">Select unit</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Additional Common Conversions -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Cubic Meters</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="m3Output">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Liters</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="litersOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Cubic Feet</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="ft3Output">--</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    

        <div class="mt-6 space-y-4">
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-slate-700 mb-2">Metric Volume Reference</h4>
                                                    <div class="grid grid-cols-2 gap-2 text-xs text-slate-500">
                                                        <div>• 1 m³ = 1000 L</div>
                                                        <div>• 1 m³ = 35.31 ft³</div>
                                                        <div>• 1 m³ = 1,000,000 cm³</div>
                                                        <div>• 1 m³ = 264.17 gallons</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>

    <x-slot name="aboutContent">
        <!-- Additional Information -->
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">About Cubic Meter Calculation</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-[11px] text-slate-500">
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Metric Standard</h4>
                                    <p>The cubic meter (m³) is the SI unit for volume, used worldwide for scientific, engineering, and commercial applications. It's essential for international trade and technical specifications.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Practical Applications</h4>
                                    <p>Used in construction, shipping, fluid dynamics, environmental science, and manufacturing for precise volume calculations in the metric system.</p>
                                </div>
                            </div>
                            <div class="mt-4 rounded-md bg-indigo-50 p-3 text-xs text-indigo-800">
                                <p class="text-sm text-indigo-800">
                                    <strong>Engineering Tip:</strong> 1 cubic meter of water weighs exactly 1000 kg (1 metric ton) at standard conditions!
                                </p>
                            </div>
                        </div>

                        <!-- Common Dimension Examples -->
                        <div class="rounded-xl border border-slate-200 bg-white p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">Common Volume Examples</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Small Room</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-dimensions="3,3,2.5">3×3×2.5 m</div>
                                    <div class="text-[11px] text-slate-500">22.5 m³</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Water Tank</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-dimensions="2,2,1">2×2×1 m</div>
                                    <div class="text-[11px] text-slate-500">4 m³</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Concrete Slab</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-dimensions="10,5,0.15">10×5×0.15 m</div>
                                    <div class="text-[11px] text-slate-500">7.5 m³</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Swimming Pool</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-dimensions="8,4,1.5">8×4×1.5 m</div>
                                    <div class="text-[11px] text-slate-500">48 m³</div>
                                </div>
                            </div>
                        </div>
    </x-slot>

    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const lengthInput = document.getElementById('length');
                        const widthInput = document.getElementById('width');
                        const heightInput = document.getElementById('height');
                        const lengthUnit = document.getElementById('lengthUnit');
                        const widthUnit = document.getElementById('widthUnit');
                        const heightUnit = document.getElementById('heightUnit');
                        const outputUnit = document.getElementById('outputUnit');
                        const clearButton = document.getElementById('clearButton');
                        const output = document.getElementById('output');
                        const unitDisplay = document.getElementById('unit-display');
                        const resultDescription = document.getElementById('result-description');
                        const m3Output = document.getElementById('m3Output');
                        const litersOutput = document.getElementById('litersOutput');
                        const ft3Output = document.getElementById('ft3Output');

                        const unitToMeter = {
                            mm: 0.001,
                            cm: 0.01,
                            m: 1,
                            km: 1000,
                            ft: 0.3048,
                            in: 0.0254,
                            yd: 0.9144
                        };

                        const m3ToOutput = {
                            m3: { rate: 1, symbol: 'm³', name: 'Cubic Meters' },
                            ft3: { rate: 35.3147, symbol: 'ft³', name: 'Cubic Feet' },
                            in3: { rate: 61023.7, symbol: 'in³', name: 'Cubic Inches' },
                            yd3: { rate: 1.30795, symbol: 'yd³', name: 'Cubic Yards' },
                            l: { rate: 1000, symbol: 'L', name: 'Liters' },
                            mm3: { rate: 1e9, symbol: 'mm³', name: 'Cubic Millimeters' },
                            cm3: { rate: 1e6, symbol: 'cm³', name: 'Cubic Centimeters' },
                            km3: { rate: 1e-9, symbol: 'km³', name: 'Cubic Kilometers' }
                        };

                        const inputs = {
                            length: {
                                el: lengthInput,
                                unitEl: lengthUnit,
                                originalValue: null,
                                originalUnit: 'm'
                            },
                            width: {
                                el: widthInput,
                                unitEl: widthUnit,
                                originalValue: null,
                                originalUnit: 'm'
                            },
                            height: {
                                el: heightInput,
                                unitEl: heightUnit,
                                originalValue: null,
                                originalUnit: 'm'
                            }
                        };

                        function convertUnit(value, from, to) {
                            return (value * unitToMeter[from]) / unitToMeter[to];
                        }

                        function formatNumber(num) {
                            if (num >= 1e15) {
                                return Number(num.toPrecision(5)).toExponential();
                            } else if (num >= 1000000) {
                                return Number(num.toPrecision(5)).toExponential();
                            } else if (num >= 1000) {
                                return num.toLocaleString(undefined, { maximumFractionDigits: 2 });
                            } else if (num >= 1) {
                                return num.toLocaleString(undefined, { maximumFractionDigits: 3 });
                            } else if (num !== 0 && Math.abs(num) < 0.000001) {
                                return Number(num.toPrecision(4)).toExponential();
                            } else {
                                return num.toLocaleString(undefined, { maximumSignificantDigits: 6 });
                            }
                        }

                        function calculateVolume() {
                            let valid = true;
                            let volumeInM3 = 1;

                            for (const key in inputs) {
                                const input = inputs[key];
                                const value = parseFloat(input.el.value);
                                if (!isNaN(value) && value > 0) {
                                    input.originalValue = value;
                                    input.originalUnit = input.unitEl.value;
                                    const valueInM = value * unitToMeter[input.unitEl.value];
                                    volumeInM3 *= valueInM;
                                } else {
                                    valid = false;
                                }
                            }

                            if (valid) {
                                const selectedUnit = outputUnit.value;
                                const conversion = m3ToOutput[selectedUnit];
                                const result = volumeInM3 * conversion.rate;

                                // Primary result
                                output.textContent = formatNumber(result);
                                unitDisplay.textContent = conversion.symbol;
                                resultDescription.textContent = conversion.name;

                                // Common conversions
                                m3Output.textContent = formatNumber(volumeInM3) + " m³";
                                litersOutput.textContent = formatNumber(volumeInM3 * 1000) + " L";
                                ft3Output.textContent = formatNumber(volumeInM3 * 35.3147) + " ft³";
                            } else {
                                output.textContent = "--";
                                unitDisplay.textContent = "Select unit";
                                resultDescription.textContent = "Calculated volume";
                                m3Output.textContent = "--";
                                litersOutput.textContent = "--";
                                ft3Output.textContent = "--";
                            }
                        }

                        function clearAll() {
                            lengthInput.value = '';
                            widthInput.value = '';
                            heightInput.value = '';
                            calculateVolume();
                            lengthInput.focus();
                        }

                        function attachEvents() {
                            for (const key in inputs) {
                                const input = inputs[key];

                                input.el.addEventListener('input', () => {
                                    const val = parseFloat(input.el.value);
                                    if (!isNaN(val)) {
                                        input.originalValue = val;
                                        input.originalUnit = input.unitEl.value;
                                    }
                                    calculateVolume();
                                });

                                input.unitEl.addEventListener('change', () => {
                                    if (input.originalValue !== null && input.originalUnit !== input.unitEl.value) {
                                        const converted = convertUnit(input.originalValue, input.originalUnit, input.unitEl.value);
                                        input.el.value = formatNumber(converted);
                                        input.originalValue = parseFloat(input.el.value);
                                        input.originalUnit = input.unitEl.value;
                                    }
                                    calculateVolume();
                                });
                            }

                            outputUnit.addEventListener('change', calculateVolume);
                        }

                        // Event listeners
                        clearButton.addEventListener('click', clearAll);

                        // Add clickable functionality to example dimensions
                        const exampleDimensions = document.querySelectorAll('[data-dimensions]');
                        exampleDimensions.forEach(element => {
                            element.addEventListener('click', function() {
                                const dimensions = this.getAttribute('data-dimensions').split(',');
                                lengthInput.value = dimensions[0];
                                widthInput.value = dimensions[1];
                                heightInput.value = dimensions[2];
                                calculateVolume();
                                lengthInput.focus();
                            });
                        });

                        // Initialize
                        attachEvents();
                        calculateVolume();
                        lengthInput.focus();

                        // Keyboard shortcuts
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape' || (e.ctrlKey && e.shiftKey && (e.key === 'C' || e.key === 'c'))) {
                                if (e.ctrlKey && e.shiftKey) {
                                    e.preventDefault();
                                }
                                clearAll();
                            }
                        });
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
