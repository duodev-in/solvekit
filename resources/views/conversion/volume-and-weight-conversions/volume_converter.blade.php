<x-tool-page-layout
    title="Volume Converter - SolveKit"
    description="Professional volume converter to convert between liters, gallons, cubic units, and other volume measurements. Fast and accurate conversions."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="space-y-2">
                            
                            <!-- Calculator Header -->
                            <div class="rounded-md bg-white p-2.5 shadow-sm">
                                <h1 class="text-sm font-semibold text-slate-900">Volume Converter</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="rounded-md bg-white p-3 shadow-sm">
                                
                                <div class="grid gap-3 lg:grid-cols-9">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-3" id="calculatorForm">

                                                                            <!-- Value and Units -->
                                                                            <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                                                                            <div class="space-y-2">
                                                                                <label for="inputValue" class="block text-sm font-semibold text-slate-700">
                                                                                    Enter Volume Value
                                                                                </label>
                                                                                <input 
                                                                                    type="number" 
                                                                                    id="inputValue" 
                                                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                    placeholder="Enter volume value"
                                                                                    step="any"
                                                                                    min="0"
                                                                                >
                                                                            </div>
                                                                                <div class="space-y-2">
                                                                                    <label for="fromUnit" class="block text-sm font-semibold text-slate-700">
                                                                                        From Unit
                                                                                    </label>
                                                                                    <select 
                                                                                        id="fromUnit" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                    >
                                                                                        <option value="ml">Milliliters (mL)</option>
                                                                                        <option value="l" selected>Liters (L)</option>
                                                                                        <option value="m3">Cubic Meters (m³)</option>
                                                                                        <option value="cm3">Cubic Centimeters (cm³)</option>
                                                                                        <option value="in3">Cubic Inches (in³)</option>
                                                                                        <option value="ft3">Cubic Feet (ft³)</option>
                                                                                        <option value="yd3">Cubic Yards (yd³)</option>
                                                                                        <option value="gal">Gallons (US)</option>
                                                                                        <option value="qt">Quarts (US)</option>
                                                                                        <option value="pt">Pints (US)</option>
                                                                                        <option value="oz">Fluid Ounces (US)</option>
                                                                                        <option value="cup">Cups (US)</option>
                                                                                    </select>
                                                                                </div>

                                                                                <div class="space-y-2">
                                                                                    <label for="toUnit" class="block text-sm font-semibold text-slate-700">
                                                                                        To Unit
                                                                                    </label>
                                                                                    <select 
                                                                                        id="toUnit" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium bg-white"
                                                                                    >
                                                                                        <option value="ml">Milliliters (mL)</option>
                                                                                        <option value="l">Liters (L)</option>
                                                                                        <option value="m3">Cubic Meters (m³)</option>
                                                                                        <option value="cm3">Cubic Centimeters (cm³)</option>
                                                                                        <option value="in3">Cubic Inches (in³)</option>
                                                                                        <option value="ft3">Cubic Feet (ft³)</option>
                                                                                        <option value="yd3">Cubic Yards (yd³)</option>
                                                                                        <option value="gal" selected>Gallons (US)</option>
                                                                                        <option value="qt">Quarts (US)</option>
                                                                                        <option value="pt">Pints (US)</option>
                                                                                        <option value="oz">Fluid Ounces (US)</option>
                                                                                        <option value="cup">Cups (US)</option>
                                                                                    </select>
                                                                                </div>
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
                                        <!-- Result Display -->
                                                                        <div class="mt-8 space-y-4">
                                                                            <h3 class="text-lg font-semibold text-slate-900 text-center mb-4">Converted Values</h3>
                                                                            <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-xs font-semibold text-slate-900" id="result-title">Converted Volume</h4>
                                                                                        <p class="text-[11px] text-slate-500" id="result-description">Enter a value to convert</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="output">--</div>
                                                                                        <div class="text-xs text-slate-500 font-medium" id="unit-display">Select units</div>
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
                                                    <h4 class="text-sm font-semibold text-slate-700 mb-2">Quick Reference</h4>
                                                    <div class="grid grid-cols-2 gap-2 text-xs text-slate-500">
                                                        <div>• 1 L = 1000 mL</div>
                                                        <div>• 1 gal = 3.785 L</div>
                                                        <div>• 1 ft³ = 28.32 L</div>
                                                        <div>• 1 cup = 240 mL</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>

    <x-slot name="aboutContent">
        <!-- Additional Information -->
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">About Volume Conversion</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-[11px] text-slate-500">
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Volume vs Capacity</h4>
                                    <p>Volume refers to the amount of space occupied by matter, while capacity refers to the amount a container can hold. Both use the same units for practical measurements.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Common Applications</h4>
                                    <p>Essential for cooking, chemistry, engineering, construction, and everyday tasks involving liquids, gases, or bulk materials.</p>
                                </div>
                            </div>
                            <div class="mt-4 rounded-md bg-indigo-50 p-3 text-xs text-indigo-800">
                                <p class="text-sm text-indigo-800">
                                    <strong>Cooking Tip:</strong> US cooking measurements differ from metric - 1 US cup = 240 mL, while 1 metric cup = 250 mL!
                                </p>
                            </div>
                        </div>

                        <!-- Common Volume Examples -->
                        <div class="rounded-xl border border-slate-200 bg-white p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">Common Volume Examples</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Teaspoon</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-volume="5" data-unit="ml">5 mL</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Water Bottle</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-volume="500" data-unit="ml">500 mL</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Milk Jug</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-volume="1" data-unit="gal">1 gallon</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Swimming Pool</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-volume="50" data-unit="m3">50 m³</div>
                                </div>
                            </div>
                        </div>
    </x-slot>

    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const inputValue = document.getElementById('inputValue');
                        const fromUnit = document.getElementById('fromUnit');
                        const toUnit = document.getElementById('toUnit');
                        const clearButton = document.getElementById('clearButton');
                        const output = document.getElementById('output');
                        const unitDisplay = document.getElementById('unit-display');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');

                        const toLiter = {
                            ml: { rate: 0.001, symbol: 'mL', name: 'Milliliters' },
                            l: { rate: 1, symbol: 'L', name: 'Liters' },
                            m3: { rate: 1000, symbol: 'm³', name: 'Cubic Meters' },
                            cm3: { rate: 0.001, symbol: 'cm³', name: 'Cubic Centimeters' },
                            in3: { rate: 0.0163871, symbol: 'in³', name: 'Cubic Inches' },
                            ft3: { rate: 28.3168, symbol: 'ft³', name: 'Cubic Feet' },
                            yd3: { rate: 764.555, symbol: 'yd³', name: 'Cubic Yards' },
                            gal: { rate: 3.78541, symbol: 'gal', name: 'US Gallons' },
                            qt: { rate: 0.946353, symbol: 'qt', name: 'US Quarts' },
                            pt: { rate: 0.473176, symbol: 'pt', name: 'US Pints' },
                            oz: { rate: 0.0295735, symbol: 'fl oz', name: 'US Fluid Ounces' },
                            cup: { rate: 0.24, symbol: 'cups', name: 'Cups' }
                        };

                        function formatNumber(num) {
                            if (num >= 1000000) {
                                return Number(num.toPrecision(5)).toExponential();
                            } else if (num >= 1000) {
                                return num.toLocaleString(undefined, { maximumFractionDigits: 2 });
                            } else if (num >= 1) {
                                return num.toLocaleString(undefined, { maximumFractionDigits: 4 });
                            } else if (num !== 0 && Math.abs(num) < 0.000001) {
                                return Number(num.toPrecision(4)).toExponential();
                            } else {
                                return num.toLocaleString(undefined, { maximumSignificantDigits: 6 });
                            }
                        }

                        function convert() {
                            const value = parseFloat(inputValue.value);
                            const from = fromUnit.value;
                            const to = toUnit.value;

                            if (!isNaN(value) && value >= 0) {
                                const inLiters = value * toLiter[from].rate;
                                const converted = inLiters / toLiter[to].rate;
                                
                                output.textContent = formatNumber(converted);
                                unitDisplay.textContent = toLiter[to].symbol;
                                resultTitle.textContent = 'Volume in ' + toLiter[to].name;
                                resultDescription.textContent = `${value} ${toLiter[from].symbol} = ${formatNumber(converted)} ${toLiter[to].symbol}`;
                            } else {
                                output.textContent = "--";
                                unitDisplay.textContent = "Select units";
                                resultTitle.textContent = 'Converted Volume';
                                resultDescription.textContent = 'Enter a value to convert';
                            }
                        }

                        function clearInput() {
                            inputValue.value = '';
                            convert();
                            inputValue.focus();
                        }

                        // Event listeners
                        inputValue.addEventListener('input', convert);
                        fromUnit.addEventListener('change', convert);
                        toUnit.addEventListener('change', convert);
                        clearButton.addEventListener('click', clearInput);

                        // Add clickable functionality to example volumes
                        const exampleVolumes = document.querySelectorAll('[data-volume]');
                        exampleVolumes.forEach(element => {
                            element.addEventListener('click', function() {
                                const volumeValue = this.getAttribute('data-volume');
                                const unitValue = this.getAttribute('data-unit');
                                
                                inputValue.value = volumeValue;
                                fromUnit.value = unitValue;
                                convert();
                                inputValue.focus();
                            });
                        });

                        // Initialize
                        inputValue.focus();
                        convert();

                        // Keyboard shortcuts
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape' || (e.ctrlKey && e.shiftKey && (e.key === 'C' || e.key === 'c'))) {
                                if (e.ctrlKey && e.shiftKey) {
                                    e.preventDefault();
                                }
                                clearInput();
                            }
                        });
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
