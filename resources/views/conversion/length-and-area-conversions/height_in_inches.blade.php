<x-tool-page-layout
    title="Height in Inches Calculator - SolveKit"
    description="Professional height calculator to convert inches to feet and inches, centimeters, and meters. Perfect for height conversions and human measurements."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="space-y-2">
                            
                            <!-- Calculator Header -->
                            <div class="rounded-md bg-white p-2.5 shadow-sm">
                                <h1 class="text-sm font-semibold text-slate-900">Height in Inches</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="rounded-md bg-white p-3 shadow-sm">
                                
                                <div class="grid gap-3 lg:grid-cols-9">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-3" id="calculatorForm">

                                                                            <!-- Input Value -->
                                                                            <div class="space-y-2">
                                                                                <label for="inches" class="block text-xs font-semibold text-slate-700">
                                                                                    Enter Height in Inches
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="inches" 
                                                                                        class="w-full rounded-md border border-slate-300 bg-white" 
                                                                                        placeholder="Enter height (e.g., 65)"
                                                                                        step="0.1"
                                                                                        min="0"
                                                                                        max="120"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-slate-500 text-sm font-medium">inches</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-[11px] text-slate-500">Typical human height range: 48-84 inches</p>
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
                                                                            <h3 class="text-lg font-semibold text-slate-900 text-center mb-4">Converted Heights</h3>

                                                                            <!-- Feet & Inches -->
                                                                            <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Feet & Inches</h4>
                                                                                        <p class="text-[11px] text-slate-500">Imperial format</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="feetInches">--</div>
                                                                                        <div class="text-xs text-slate-500 font-medium">ft & in</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Centimeters -->
                                                                            <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Centimeters</h4>
                                                                                        <p class="text-[11px] text-slate-500">Metric measurement</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="centimeters">--</div>
                                                                                        <div class="text-xs text-slate-500 font-medium">cm</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Meters -->
                                                                            <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Meters</h4>
                                                                                        <p class="text-[11px] text-slate-500">Base metric unit</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="meters">--</div>
                                                                                        <div class="text-xs text-slate-500 font-medium">m</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    

</x-slot>

    <x-slot name="aboutContent">
        <!-- Additional Information -->
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">About Height Conversion</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-[11px] text-slate-500">
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Height Measurements</h4>
                                    <p>Height is commonly measured in inches in the United States, while most other countries use centimeters. This calculator helps convert between both systems for medical records, sports, and international applications.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Common Uses</h4>
                                    <p>Essential for medical charts, sports statistics, clothing sizes, ergonomic design, and converting between imperial and metric measurement systems in various professional contexts.</p>
                                </div>
                            </div>
                            <div class="mt-4 rounded-md bg-indigo-50 p-3 text-xs text-indigo-800">
                                <p class="text-sm text-indigo-800">
                                    <strong>Medical Note:</strong> Height measurements are crucial for calculating BMI, medication dosages, and growth tracking!
                                </p>
                            </div>
                        </div>

                        <div class="rounded-xl border border-slate-200 bg-white p-3 shadow-sm">
                            <h3 class="text-base font-semibold text-slate-900 mb-3">Quick Reference</h3>
                            <div class="grid grid-cols-1 gap-2 text-xs text-slate-600 sm:grid-cols-2">
                                <div>• 1 inch = 2.54 cm</div>
                                <div>• 1 foot = 12 inches</div>
                                <div>• 5 feet = 60 inches</div>
                                <div>• 6 feet = 72 inches</div>
                            </div>
                        </div>

                        <!-- Common Height Examples -->
                        <div class="rounded-xl border border-slate-200 bg-white p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">Common Height Examples</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Short Adult</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-height="60">60 inches</div>
                                    <div class="text-[11px] text-slate-500">5'0"</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Average Woman</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-height="64">64 inches</div>
                                    <div class="text-[11px] text-slate-500">5'4"</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Average Man</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-height="69">69 inches</div>
                                    <div class="text-[11px] text-slate-500">5'9"</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Tall Adult</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-height="76">76 inches</div>
                                    <div class="text-[11px] text-slate-500">6'4"</div>
                                </div>
                            </div>
                        </div>
    </x-slot>

    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const inchesInput = document.getElementById('inches');
                        const clearButton = document.getElementById('clearButton');
                        const feetInches = document.getElementById('feetInches');
                        const centimeters = document.getElementById('centimeters');
                        const meters = document.getElementById('meters');

                        function formatMeasurement(value, fractionDigits) {
                            if (value !== 0 && Math.abs(value) < 0.000001) {
                                return Number(value.toPrecision(4)).toExponential();
                            } else if (Math.abs(value) < 1) {
                                return value.toLocaleString(undefined, { maximumSignificantDigits: 4 });
                            }

                            return value.toLocaleString(undefined, { maximumFractionDigits: fractionDigits });
                        }

                        function convert() {
                            const inches = parseFloat(inchesInput.value);
                            
                            if (!isNaN(inches) && inches > 0) {
                                // Calculate conversions
                                const feet = Math.floor(inches / 12);
                                const remainingInches = inches % 12;
                                const cm = inches * 2.54;
                                const m = cm / 100;

                                // Format feet and inches
                                let feetInchesText;
                                if (feet > 0 && remainingInches > 0) {
                                    feetInchesText = `${feet}' ${formatMeasurement(remainingInches, 1)}"`;
                                } else if (feet > 0) {
                                    feetInchesText = `${feet}' 0"`;
                                } else {
                                    feetInchesText = `0' ${formatMeasurement(remainingInches, 1)}"`;
                                }

                                // Display results
                                feetInches.textContent = feetInchesText;
                                centimeters.textContent = formatMeasurement(cm, 1);
                                meters.textContent = formatMeasurement(m, 3);
                            } else {
                                // Clear results
                                feetInches.textContent = "--";
                                centimeters.textContent = "--";
                                meters.textContent = "--";
                            }
                        }

                        function clearInput() {
                            inchesInput.value = '';
                            convert();
                            inchesInput.focus();
                        }

                        // Event listeners
                        inchesInput.addEventListener('input', convert);
                        clearButton.addEventListener('click', clearInput);

                        // Add clickable functionality to example heights
                        const exampleHeights = document.querySelectorAll('[data-height]');
                        exampleHeights.forEach(element => {
                            element.addEventListener('click', function() {
                                const heightValue = this.getAttribute('data-height');
                                inchesInput.value = heightValue;
                                convert();
                                inchesInput.focus();
                            });
                        });

                        // Initialize
                        inchesInput.focus();

                        // Add keyboard shortcuts
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape' || (e.ctrlKey && e.shiftKey && (e.key === 'C' || e.key === 'c'))) {
                                if (e.ctrlKey && e.shiftKey) {
                                    e.preventDefault();
                                }
                                clearInput();
                            }
                        });

                        // Input validation
                        inchesInput.addEventListener('input', function() {
                            const value = parseFloat(this.value);
                            if (value > 120) {
                                this.value = 120;
                            } else if (value < 0) {
                                this.value = 0;
                            }
                        });

                        // Initialize conversion
                        convert();
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
