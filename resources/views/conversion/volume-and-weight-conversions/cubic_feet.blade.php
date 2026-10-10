<x-tool-page-layout
    title="Cubic Feet Calculator - SolveKit"
    description="Professional cubic feet calculator to calculate volume in ft³ from length, width, and height dimensions. Perfect for construction and storage calculations."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="space-y-2">
                            
                            <!-- Calculator Header -->
                            <div class="rounded-md bg-white p-2.5 shadow-sm">
                                <h1 class="text-sm font-semibold text-slate-900">Cubic Feet Calculator</h1>
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
                                                                                        <option value="m">m</option>
                                                                                        <option value="km">km</option>
                                                                                        <option value="in">in</option>
                                                                                        <option value="ft" selected>ft</option>
                                                                                        <option value="yd">yd</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            @endforeach

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

                                                                            <!-- Primary Result - Cubic Feet -->
                                                                            <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Volume in Cubic Feet</h4>
                                                                                        <p class="text-[11px] text-slate-500">Imperial volume measurement</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="output">--</div>
                                                                                        <div class="text-xs text-slate-500 font-medium">ft³</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Additional Conversions -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Cubic Meters</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="cubicMetersOutput">--</div>
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
                                                                                        <h4 class="text-xs font-semibold text-slate-900">US Gallons</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="gallonsOutput">--</div>
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
                                                    <h4 class="text-sm font-semibold text-slate-700 mb-2">Volume Conversion Reference</h4>
                                                    <div class="grid grid-cols-2 gap-2 text-xs text-slate-500">
                                                        <div>• 1 ft³ = 0.0283 m³</div>
                                                        <div>• 1 ft³ = 28.32 L</div>
                                                        <div>• 1 ft³ = 7.48 gallons</div>
                                                        <div>• 1 ft³ = 1,728 in³</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>

    <x-slot name="aboutContent">
        <!-- Additional Information -->
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">About Cubic Feet Calculation</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-[11px] text-slate-500">
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Practical Applications</h4>
                                    <p>Essential for shipping calculations, storage planning, concrete ordering, HVAC sizing, and any project requiring volume measurements in the imperial system.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Construction Uses</h4>
                                    <p>Commonly used in construction for calculating concrete needs, lumber volume, room capacity, and material storage requirements.</p>
                                </div>
                            </div>
                            <div class="mt-4 rounded-md bg-indigo-50 p-3 text-xs text-indigo-800">
                                <p class="text-sm text-indigo-800">
                                    <strong>Construction Tip:</strong> Always add 10% extra when ordering materials to account for waste and measurement variations!
                                </p>
                            </div>
                        </div>

                        <!-- Common Dimension Examples -->
                        <div class="rounded-xl border border-slate-200 bg-white p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">Common Volume Examples</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Small Room</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-dimensions="10,10,8">10×10×8 ft</div>
                                    <div class="text-[11px] text-slate-500">800 ft³</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Shipping Container</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-dimensions="20,8,8.5">20×8×8.5 ft</div>
                                    <div class="text-[11px] text-slate-500">1,360 ft³</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Concrete Pad</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-dimensions="20,20,0.5">20×20×0.5 ft</div>
                                    <div class="text-[11px] text-slate-500">200 ft³</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Storage Unit</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-dimensions="5,10,8">5×10×8 ft</div>
                                    <div class="text-[11px] text-slate-500">400 ft³</div>
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
                        const clearButton = document.getElementById('clearButton');
                        const output = document.getElementById('output');
                        const cubicMetersOutput = document.getElementById('cubicMetersOutput');
                        const litersOutput = document.getElementById('litersOutput');
                        const gallonsOutput = document.getElementById('gallonsOutput');

                        const unitToMeter = {
                            mm: 0.001,
                            cm: 0.01,
                            m: 1,
                            km: 1000,
                            ft: 0.3048,
                            in: 0.0254,
                            yd: 0.9144
                        };

                        const inputs = {
                            length: {
                                el: lengthInput,
                                unitEl: lengthUnit,
                                originalValue: null,
                                originalUnit: 'ft'
                            },
                            width: {
                                el: widthInput,
                                unitEl: widthUnit,
                                originalValue: null,
                                originalUnit: 'ft'
                            },
                            height: {
                                el: heightInput,
                                unitEl: heightUnit,
                                originalValue: null,
                                originalUnit: 'ft'
                            }
                        };

                        const M3_TO_FT3 = 35.3147;
                        const FT3_TO_LITERS = 28.3168;
                        const FT3_TO_GALLONS = 7.48052;

                        function convertUnit(value, from, to) {
                            return (value * unitToMeter[from]) / unitToMeter[to];
                        }

                        function formatNumber(num) {
                            if (num >= 1000000) {
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
                                const volumeInFt3 = volumeInM3 * M3_TO_FT3;
                                const volumeInLiters = volumeInFt3 * FT3_TO_LITERS;
                                const volumeInGallons = volumeInFt3 * FT3_TO_GALLONS;

                                output.textContent = formatNumber(volumeInFt3);
                                cubicMetersOutput.textContent = formatNumber(volumeInM3) + " m³";
                                litersOutput.textContent = formatNumber(volumeInLiters) + " L";
                                gallonsOutput.textContent = formatNumber(volumeInGallons) + " gal";
                            } else {
                                output.textContent = "--";
                                cubicMetersOutput.textContent = "--";
                                litersOutput.textContent = "--";
                                gallonsOutput.textContent = "--";
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
